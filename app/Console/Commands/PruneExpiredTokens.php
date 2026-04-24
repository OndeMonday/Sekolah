<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

class PruneExpiredTokens extends Command
{
    protected $signature = 'tokens:prune-expired';
    protected $description = 'Hapus token Sanctum yang sudah expired';

    public function handle()
    {
        $count = PersonalAccessToken::whereNotNull('expires_at')
            ->where('expires_at', '<=', Carbon::now())
            ->delete();
    }
}
