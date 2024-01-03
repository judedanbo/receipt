<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Staff extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

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
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'staff_number',
        'title',
        'surname',
        'other_names',
        'email',
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function offices(): BelongsToMany
    {
        return $this->belongsToMany(Office::class);
    }
}
