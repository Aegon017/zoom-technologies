<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use Illuminate\Console\Command;

class ExpireSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedules:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire schedules with start_date before today and set their status to false';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Call the method to expire schedules
        Schedule::expireSchedule();

        // Output a success message
        $this->info('Schedules with past start dates have been expired.');
    }
}
