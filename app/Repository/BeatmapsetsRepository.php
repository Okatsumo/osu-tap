<?php

namespace App\Repository;

use App\Exceptions\OperationError;
use App\Models\Beatmapset;

class BeatmapsetsRepository extends BaseEloquentRepository
{
    public function __construct()
    {

        $this->setModelClass(Beatmapset::class);
    }

    /**
     * @throws OperationError
     */
    public function enableCover(int $id): void
    {
        $beatmapsets = $this->get($id, 'is_cover');

        $beatmapsets->is_cover = true;
        $beatmapsets->update();
    }

    /**
     * @throws OperationError
     */
    public function disabledCover(int $id): void
    {
        $beatmapsets = $this->get($id, 'is_cover');

        $beatmapsets->is_cover = false;
        $beatmapsets->update();
    }

    /**
     * @throws OperationError
     */
    public function disablePreview(int $id)
    {
        $beatmapsets = $this->get($id, 'is_preview');

        $beatmapsets->is_preview = false;
        $beatmapsets->update();
    }

    /**
     * @throws OperationError
     */
    public function ebablePreview(int $id)
    {
        $beatmapsets = $this->get($id, 'is_preview');

        $beatmapsets->is_preview = true;
        $beatmapsets->update();
    }
}
