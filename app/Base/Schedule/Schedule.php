<?php

namespace App\Base\Schedule;

use Illuminate\Console\Scheduling\Schedule as SystemSchedule;
class Schedule
{
    private \Illuminate\Console\Scheduling\Schedule $schedule;

    /**
     *  Запуск очередей
     */
    public function run(SystemSchedule $schedule): void
    {
        $this->schedule = $schedule;

        $this->parser($schedule);
    }

    /**
     *  Парсер
     */
    public function parser(SystemSchedule $schedule): void
    {
        $schedule->call(function () {

        })->daily();
    }
}
