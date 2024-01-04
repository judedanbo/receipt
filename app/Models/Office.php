<?php

namespace App\Models;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
        return $this->belongsToMany(Staff::class)->latest();
    }

    public static function getForm(): array {
        return [
            TextInput::make('code')
                ->required()
                ->maxLength(4),
            TextInput::make('name')
                ->required()
                ->maxLength(40),
            // Select::make('staff')
            //     ->relationship('staff', 'full_name')
            //     ->options(Staff::->all()->pluck('full_name', 'id'))
            //     ->searchable()
            //     ->preload()
            //     ->
            //     ,
        ];
    }
}
