<?php

namespace App\Base\Dto;

use App\Base\Enums\FileType;

final class File
{
    public function __construct(
        public string $fullName,
        public string $name,
        public int $size,
        public FileType $type,
        public string $contents,
    ){}
}
