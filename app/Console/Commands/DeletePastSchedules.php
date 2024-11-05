<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;

class DeletePastSchedules extends Command
{
    protected $signature = 'schedules:delete-past';
    protected $description = 'Delete schedules with start_date in the past';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Schedule::deletePastSchedules();
        $this->info('Past schedules deleted successfully.');
    }
}
