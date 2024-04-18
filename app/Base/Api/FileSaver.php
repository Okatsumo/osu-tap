<?php

namespace App\Base\Api;

use App\Base\Dto\File;
use Illuminate\Filesystem\FilesystemManager;

class FileSaver
{
    protected FilesystemManager $filesystem_manager;
    protected string $disk;

    public function __construct(FilesystemManager $filesystem_manager)
    {
        $this->filesystem_manager = $filesystem_manager;
    }

    /**
     * @param File $file
     * @param string $path
     */
    public function save(File $file, string $path): void
    {
        $path = $path.'/'.$file->fullName;

        $this->filesystem_manager->disk($this->disk)->put($path, $file->contents);
    }

    public function setDisk(string $name): void
    {
        $this->disk = $name;
    }
}
