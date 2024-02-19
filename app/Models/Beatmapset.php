<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
