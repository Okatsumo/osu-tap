<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $parser = new \App\Services\Osu\Parser\Parser();
        $parser->start();
    }
}
