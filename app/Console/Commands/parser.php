<?php

namespace App\Console\Commands;

use App\Exceptions\OperationError;
use App\Jobs\Parser\Beatmapsets\BeatmapsetParser;
use App\Jobs\Parser\Beatmapsets\BeatmapsetsParser;
use App\Jobs\Parser\Beatmapsets\SaveCover;
use App\Repository\BeatmapsetsRepository;
use App\Repository\OsuAccountRepository;
use App\Services\Osu\Api\Beatmapsets;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

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
//        $parser = new \App\Services\Osu\Parser\Parser();
//        $parser->start();
    }
}
