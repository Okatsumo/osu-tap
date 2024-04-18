<?php

namespace App\Base\Enums;

enum FileType: string
{
    case gif = 'image/gif';
    case jpeg = 'image/jpeg';
    case png = 'image/png';
    case webp = 'image/webp';
    case mpeg = 'audio/mpeg';
    case ogg = 'audio/ogg';
    case mp4 = 'audio/mp4';
    case mp3 = 'audio/mp3';
}
