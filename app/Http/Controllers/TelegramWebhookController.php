<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MuridTelegramKontak;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $update = $request->all();

        // pastikan ada message
        if (!isset($update['message'])) {
            return response()->json(['status' => 'no message']);
        }

        $message = $update['message'];

        $chatId = $message['chat']['id'] ?? null;
        $text = $message['text'] ?? '';

        if (!$chatId) {
            return response()->json(['status' => 'no chat id']);
        }

        $nisn = null;


        if (str_starts_with($text, '/start')) {

            $parts = explode(' ', $text);
            $nisn = $parts[1] ?? null;

            MuridTelegramKontak::updateOrCreate(
                [
                    'chat_id' => $chatId
                ],
                [
                    'student_nisn' => $nisn,
                    'nama' => $message['chat']['first_name'] ?? 'user',
                    'chat_id' => $chatId
                ]
            );

            return response()->json([
                'status' => 'bound',
                'chat_id' => $chatId,
                'nisn' => $nisn
            ]);
        }

        return response()->json([
            'status' => 'ignored'
        ]);
    }
}