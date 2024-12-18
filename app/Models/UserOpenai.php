<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserOpenai extends Model
{
    protected $table = 'user_openai';

    protected $guarded = [];

    protected $fillable = [
        'team_id',
        'title',
        'slug',
        'user_id',
        'openai_id',
        'input',
        'response',
        'output',
        'hash',
        'credits',
        'words',
        'payload',
        'storage',
        'status',
        'request_id',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    protected $appends = [
        'format_date',
        'generator_type',
    ];

    // STORAGE
    public const STORAGE_LOCAL = 'public';

    public const STORAGE_AWS = 's3';

    public function generator(): BelongsTo
    {
        return $this->belongsTo(OpenAIGenerator::class, 'openai_id', 'id');
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folders::class);
    }

    public function getFormatDateAttribute()
    {
        if ($this?->created_at) {
            return $this?->created_at?->format('M d, Y');
        } else {
            return null;
        }
    }

    public function generatorWithType(): BelongsTo
    {
        return $this->belongsTo(OpenAIGenerator::class, 'openai_id', 'id')->select(['id', 'type']);
    }

    public function isFavoriteDoc(): bool
    {
        return (bool) $this->isFavoriteDocRelation;
    }

    public function isFavoriteDocRelation(): HasOne
    {
        return $this->hasOne(UserDocsFavorite::class, 'user_openai_id', 'id')
            ->where('user_id', auth()->id());
    }

    public function getGeneratorTypeAttribute()
    {
        return $this->generator?->type;
    }
}
