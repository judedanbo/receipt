<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'staff_number',
        'title',
        'surname',
        'other_names',
        'email',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function offices(): BelongsToMany
    {
        return $this->belongsToMany(Office::class);
    }
}
