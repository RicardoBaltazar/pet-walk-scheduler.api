<?php

namespace App\Jobs;

use App\Models\Schedule;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ScheduleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle($data): void
    {
        Log::info('Disparando job.');
        // try {
        //     $schedule = new Schedule();
        //     Log::info('Agendando passeio.');
        //     $schedule->create($data);
        // } catch (Exception $e) {
        //     Log::error('Erro ao adicionar registro ao banco de dados: ' . $e->getMessage());
        // }
    }
}
