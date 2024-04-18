<?php

namespace App\Contracts\Jobs;

interface BaseOsuParser
{
    public function parse(): void;
}
