<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Beatmapset extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'artist',
        'artist_unicode',
        'cover',
        'creator',
        'nsfw',
        'play_count',
        'preview_url',
        'source',
        'spotlight',
        'status',
        'title',
        'title_unicode',
        'user_id',
        'video',
        'bpm',
        'ranked',
        'ranked_date',
        'storyboard',
        'submitted_date',
        'tags',
        'last_updated',
    ];

    public function beatmaps(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Beatmap::class);
    }

    protected function getFile($path)
    {
        if (!$this->is_cover) {
            return '/assets/map_cover.jpg';
        }

        $disk = Storage::disk('beatmapsets');

        if ($disk->exists($path)) {
            return $disk->url($path);

        }

        return '/assets/map_cover.jpg';
    }

    public function getCoverAttribute(): string
    {
        return $this->getFile($this->id.'/cover.jpg');
    }

    public function getCardAttribute(): string
    {
        return $this->getFile($this->id.'/card.jpg');
    }
}
