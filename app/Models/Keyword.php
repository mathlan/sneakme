<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'answer_id',
        'type'
    ];
    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}
