<?php

namespace App\Console\Commands;

use App\Services\Osu\Parser\OsuParser;
use Illuminate\Console\Command;

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
    public function handle(): void
    {
        $parser = new OsuParser();
        $parser->parseBeatmapsets();
    }
}
