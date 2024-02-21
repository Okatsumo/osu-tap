<?php

namespace App\Console\Commands;

use App\Base\Api\FileSaver;
use App\Exceptions\OperationError;
use App\Repository\BeatmapsetsRepository;
use App\Services\Osu\Api\Beatmapsets;
use App\Services\Osu\Parser\OsuParser;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

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
     * @throws OperationError
     */
    public function handle(): void
    {
        $parser = new OsuParser();
        $parser->parseBeatmapsets();
    }
}
