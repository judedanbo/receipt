<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Office extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'code',
        'name',
    ];

    protected $casts = [
        'id' => 'integer',
    ];
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'code',
        'name',
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function declarations(): HasMany
    {
        return $this->hasMany(Declaration::class);
    }

    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class);
    }
}
