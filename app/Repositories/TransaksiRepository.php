<?php

namespace App\Repositories;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Interfaces\TransaksiInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 

class TransaksiRepository implements TransaksiInterface
{
    protected Transaksi $transaksi;

    public function __construct(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
       Config::$isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION'), FILTER_VALIDATE_BOOLEAN);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function get()
    {
        return $this->transaksi
            ->with(['user', 'detail.menu'])
            ->latest()
            ->get();
    }

    public function detail(string $id)
    {
        return $this->transaksi
            ->with(['user', 'detail.menu'])
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {

        $user = auth()->user();

            $total = 0;
            $items = [];

            $transaksi = $this->transaksi->create([
                'user_id' => $user->nisn_nip,
                'total_harga' => 0,
                'status' => 'pending',
                'kode_pembayaran' => 'TRX-' . Str::random(10),
                'metode_pembayaran' => 'qris'
            ]);

            foreach ($data['items'] as $item) {

                $menu = Menu::lockForUpdate()->findOrFail($item['menu_id']);

                if ($menu->stok < $item['qty']) {
                    throw new \Exception($menu->name . ' stok tidak cukup');
                }

                $subtotal = $menu->harga * $item['qty'];

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id' => $menu->id,
                    'qty' => $item['qty'],
                    'harga' => $menu->harga,
                    'subtotal' => $subtotal
                ]);


            $menu->decrement(
                'stok',
                $item['qty']
            );

                $total += $subtotal;

                $items[] = [
                    'id' => $menu->id,
                    'price' => $menu->harga,
                    'quantity' => $item['qty'],
                    'name' => $menu->name
                ];
            }

            $transaksi->update([
                'total_harga' => $total
            ]);

            $params = [
                'transaction_details' => [
                    'order_id' => $transaksi->kode_pembayaran,
                    'gross_amount' => $total
                ],
                'item_details' => $items
            ];

            $snapToken = Snap::getSnapToken($params);

            DB::commit();

            return [
                'transaksi' => $transaksi,
                'snap_token' => $snapToken
            ];

        } catch (\Exception $e) {

            DB::rollBack();
            throw $e;
        }
    }

public function callback(Request $request)
{
    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    \Midtrans\Config::$isProduction = filter_var(
        env('MIDTRANS_IS_PRODUCTION'),
        FILTER_VALIDATE_BOOLEAN
    );

    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $status = $request->transaction_status;
    $orderId = $request->order_id;

    $transaksi = $this->transaksi
        ->with('detail.menu')
        ->where('kode_pembayaran', $orderId)
        ->first();

    if (!$transaksi) {
        return response()->json([
            'error' => 'not found'
        ]);
    }

    if ($transaksi->status !== 'pending') {
        return response()->json([
            'message' => 'already processed'
        ]);
    }

    if (in_array($status, ['settlement', 'capture'])) {

        $transaksi->update([
            'status' => 'sukses'
        ]);
    }

    if (in_array($status, ['expire', 'cancel', 'deny'])) {

        DB::transaction(function () use ($transaksi) {

            foreach ($transaksi->detail as $detail) {

                $detail->menu->increment(
                    'stok',
                    $detail->qty
                );
            }

            $transaksi->update([
                'status' => 'gagal'
            ]);
        });
    }

    return response()->json([
        'ok' => true
    ]);
}
}