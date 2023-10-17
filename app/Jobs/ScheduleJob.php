<?php

namespace App\Jobs;

use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ScheduleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(Schedule $schedule): void
    {
        try {
            Log::info('Inside handle method');
            Log::info($this->data);

            if (!$schedule) {
                Log::info('RecipeRepository is null');
            }

            $schedule->create($this->data);
            Log::info('Creating new schedule with queue');
        } catch (\Exception $e) {
            Log::info("Unable to dispatch the queue. Reason: " . $e->getMessage());
        }
    }
}
