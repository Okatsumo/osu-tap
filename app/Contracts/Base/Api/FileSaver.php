<?php

namespace App\Contracts\Base\Api;

use App\Base\Dto\File;

interface FileSaver
{
    /**
     * @param File $file
     * @param string $path
     */
    public function save(File $file, string $path): void;

    public function setDisk(string $name): void;
}
