<?php

namespace App\Base\Api;

use App\Exceptions\OperationError;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;

class FileSaver
{
    protected FilesystemManager $filesystem_manager;

    protected string $disk;

    protected Client $httpClient;

    protected array $mime = [
        'image/gif',
        'image/jpeg',
        'image/png',
        'image/webp',
        'audio/mpeg',
        'audio/ogg',
        'audio/mp4',
        'audio/mp3'
    ];

    public function __construct(FilesystemManager $filesystem_manager, Client $client)
    {
        $this->filesystem_manager = $filesystem_manager;
        $this->httpClient = $client;
    }

    /**
     * @throws OperationError
     */
    public function save(string $url, string $path, string $name): void
    {
        try {
            $data = $this->httpClient->get($url);

        } catch (GuzzleException $ex) {
            throw new OperationError($ex->getMessage(), $ex->getCode());
        }

        $content = $data->getBody()->getContents();
        $mime = $data->getHeader('content-type')[0];

        if (!in_array($mime, $this->mime)) {
            throw new OperationError('Illegal mime type');
        }
        if (empty($this->disk)) {
            throw new OperationError('Illegal disk');
        }

        $extension = explode('.', $url);
        $extension = end($extension);
        $extension = explode('?', $extension)[0];
        $path = $path.'/'.$name.'.'.$extension;

        $this->filesystem_manager->disk($this->disk)->put($path, $content);
    }

    public function setDisk(string $name): void
    {
        $this->disk = $name;
    }
}
