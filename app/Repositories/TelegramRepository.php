<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TelegramRepository
{
public function getByNisn(string $nisn)
{
    return DB::table('murid_telegram_kontak')
        ->whereRaw('TRIM(student_nisn) = ?', [trim($nisn)])
        ->first();
}
public function sendMessage(string $chatId, string $message)
{
    $token = env('TELEGRAM_BOT_TOKEN');

    $url = "https://api.telegram.org/bot{$token}/sendMessage";

    $response = Http::asForm()->post($url, [
        'chat_id' => (string) $chatId,
        'text' => trim($message),
    ]);

    return $response->body(); // jangan json dulu
}
}