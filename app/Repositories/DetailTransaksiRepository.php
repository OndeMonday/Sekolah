<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Models\DetailTransaksi;
use App\Interfaces\DetailTransaksiInterface;

class DetailTransaksiRepository
implements DetailTransaksiInterface
{
    protected DetailTransaksi $detail;

    public function __construct(
        DetailTransaksi $detail
    ){
        $this->detail = $detail;
    }

    public function get()
    {
        return $this->detail
        ->with([
            'menu',
            'transaksi'
        ])
        ->latest()
        ->get();
    }

    public function detail(string $id)
    {
        return $this->detail
        ->with([
            'menu',
            'transaksi'
        ])
        ->findOrFail($id);
    }

    public function create(array $data)
    {
        $menu = Menu::findOrFail(
            $data['menu_id']
        );

        $subtotal =
        $menu->harga * $data['qty'];

        return $this->detail
        ->create([
            'transaksi_id' => $data['transaksi_id'],
            'menu_id' => $menu->id,
            'qty' => $data['qty'],
            'harga' => $menu->harga,
            'subtotal' => $subtotal
        ]);
    }

    public function update(
        array $data,
        string $id
    ){
        $detail = $this->detail
        ->findOrFail($id);

        $subtotal =
        $detail->harga * $data['qty'];

        $detail->update([
            'qty' => $data['qty'],
            'subtotal' => $subtotal
        ]);

        return $detail->fresh();
    }

    public function delete(string $id)
    {
        $detail = $this->detail
        ->findOrFail($id);

        $detail->delete();

        return $detail;
    }
}