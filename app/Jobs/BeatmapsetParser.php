<?php

namespace App\Jobs;

use App\Exceptions\OperationError;
use App\Repository\BeatmapsetsRepository;
use App\Services\Api\ApiThrottle;
use App\Services\Osu\Api\Beatmapsets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;

class BeatmapsetParser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 0;
    private Beatmapsets $api;
    private int $id;
    private BeatmapsetsRepository $repo;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function prepare(): void
    {
        $this->apiThrottle = new ApiThrottle('osu', config('services.osu.throttle_settings'));
        $this->api = new Beatmapsets();
        $this->repo = new BeatmapsetsRepository();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->prepare();
        $this->apiThrottle->addCount();

        if ($this->apiThrottle->check()) {
            $this->release($this->apiThrottle->getTimeOut());
        } else {

            try {
                $beatmapset = $this->api->getItem($this->id);
                $this->save($beatmapset);

            } catch (InvalidArgumentException|NotFoundExceptionInterface|ContainerExceptionInterface|OperationError $e) {

                if ($e->getCode() !== 404) {
                    $this->fail($e);
                    Log::error('Osu beatmapset (id: '.$this->id.') parser exception => '.$e);
                }
            }
        }
    }

    public function save($data)
    {
        $this->repo->save([
            'id'                => $data['id'],
            'artist'            => $data['artist'],
            'artist_unicode'    => $data['artist_unicode'],
            'creator'           => $data['creator'],
            'nsfw'              => $data['nsfw'],
            'play_count'        => $data['play_count'],
            'source'            => $data['source'],
            'spotlight'         => $data['spotlight'],
            'status'            => $data['status'],
            'title'             => $data['title'],
            'title_unicode'     => $data['title_unicode'],
            'user_id'           => $data['user_id'],
            'video'             => $data['video'],
            'bpm'               => $data['bpm'],
            'ranked'            => $data['ranked'],
            'ranked_date'       => Carbon::parse($data['ranked_date']),
            'storyboard'        => $data['storyboard'],
            'submitted_date'    => Carbon::parse($data['submitted_date']),
            'tags'              => $data['tags'],
            'last_updated'      => Carbon::parse($data['last_updated'])
        ]);
    }
}
