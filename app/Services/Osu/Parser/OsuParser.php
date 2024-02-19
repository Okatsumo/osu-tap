<?php

namespace App\Services\Osu\Parser;

use App\Jobs\BeatmapParse;

class OsuParser
{

    public function __construct()
    {

    }

    public function parseBeatmapsets()
    {
        // записать куда-то страницу, которую я сейчас сохраняю в бд и отправить парсинг этой страницы в очередь

        //НУЖНО ЗАРЕГАТЬ СЕРВИС ApiThrottle как OsuApiThrottle с соответсвтенно его настройками, т.к. сервис будет использоваться в нескольких точках

        // app('api.throttle.osu')->addCount(1); // <- чет типо этого должно получиться


        for ($i = 1; $i < 40; $i++) {
            BeatmapParse::dispatch($i);
        }
    }

}
