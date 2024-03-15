<?php

namespace App\Console\Commands;

use App\Jobs\BeatmapsetParser;
use App\Services\Osu\Api\Beatmapsets;
use App\Services\Osu\Parser\BeatmapestsParser;
use Illuminate\Console\Command;
use \App\Services\Osu\Parser\Parser as OsuParser;

class parser extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:start';

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
        $parser->start();
    }
}
