<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Submission;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PruneOldSubmissions extends Command
{
    protected $signature = 'prune:old-submissions';
    protected $description = 'Hapus submission > 30 hari beserta fotonya dan task terkait';

    public function handle()
    {
        $this->info("Mulai hapus submission lama...");

        Submission::where('created_at', '<', now()->subDays(30))
            ->chunk(50, function($submissions) {
                foreach ($submissions as $submission) {
                    if ($submission->photo_path && Storage::disk('public')->exists($submission->photo_path)) {
                        Storage::disk('public')->delete($submission->photo_path);
                    }

                    $submission->delete();
                }
            });

        $this->info("Submission lama berhasil dihapus.");

        // Hapus task yang sudah kadaluarsa, misal status = completed atau tanggal selesai > 60 hari
        Task::where('completed_at', '<', now()->subDays(60))
            ->chunk(50, function($tasks) {
                foreach ($tasks as $task) {
                    $task->delete();
                }
            });

        $this->info("Task lama berhasil dihapus.");
    }
}
