<?php

namespace App\Console\Commands;

use App\Services\Api\ApiThrottle;
use App\Services\Osu\Parser\OsuParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class parser extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // сначала парсер должен чекнуть че там по тротлингу, чекнуть в Redis timestamp и отложить очередь, если сработал тротлинг
        //, в противном случае запустить парсер

        $parser = new OsuParser();
        $parser->parseBeatmapsets();
    }
}
