<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessProfileImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $userId,
        public string $tempPath
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);
        if (! $user) {
            Storage::disk('local')->delete($this->tempPath);
            return;
        }

        // Delete old profile image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $filename = 'images/profiles/' . basename($this->tempPath);

        // Move the uploaded image to the public storage disk
        if (Storage::disk('local')->exists($this->tempPath)) {
            Storage::disk('public')->put(
                $filename,
                Storage::disk('local')->get($this->tempPath)
            );

            Storage::disk('local')->delete($this->tempPath);
            $user->update(['profile_image' => $filename]);
        }
    }
}
