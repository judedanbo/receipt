<?php

namespace App\Models;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Declaration extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'receipt_no',
        'declared_date',
        'post',
        'schedule',
        'office_location',
        'address',
        'contact',
        'witness',
        'witness_occupation',
        'submitted_by',
        'submitted_by_contact',
        'qr_code',
        'synced',
        'office_id',
        'user_id',
        'staff_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'office_id' => 'integer',
        'user_id' => 'integer',
        'staff_id' => 'integer',
    ];
    protected $hidden = [
        'synced'
    ];
    protected static $logAttributes = [
        'receipt_no',
        'declared_date',
        'name',
        'post',
        'schedule',
        'office_location',
        'address',
        'contact',
        'witness',
        'witness_occupation',
        'submitted_by',
        'submitted_by_contact',
        'qr_code',
        'synced',
        'office_id',
        'user_id',
        'staff_id',
        'old_received_by',
        'old_serial_no',
        'old_declaration_id',
    ];
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
  

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getForm(): array {
        return [
            // TextInput::make('receipt_no')
            //     ->required()
            //     ->maxLength(10),
            DatePicker::make('declared_date')
                ->autofocus()
                ->default(now())
                ->columns(['sm' => 1, 'md' => 2])
                ->columnStart(['sm' => 1, 'md' =>2, 'lg' => 3,])
                ->native(false),
            Section::make("Declarant Name")
                ->columns(['sm' => 1, 'md' => 2 ])
                ->columnStart(['sm' => 1, ])
                ->schema([
                    TextInput::make('name')
                        ->label("Declarant's full name with title")
                        ->required()
                        ->maxLength(255),
                ]),  
                Section::make("Witness")
                ->columnSpan(['sm' => 1, 'md' => 2])
                ->columnStart(['lg' => 3, ])
                ->collapsible()
                ->schema([
                TextInput::make('witness')
                    ->label('Witness Name')
                    ->maxLength(255),
                TextInput::make('witness_occupation')
                    ->maxLength(255),
            ])
                ->columns(2),
            Section::make("Post / Schedule")
                ->columns(['sm' => 1, 'md' => 2, ])
              
                ->collapsible()
                ->schema([
                    TextInput::make('post')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('schedule')
                        ->maxLength(255),
                    TextInput::make('office_location')
                        ->columnSpanFull()
                        ->maxLength(255),
                ])
                ->columns(2),
                Section::make("Address / Contact")
                    ->columns(['sm' => 1, 'md' => 2])
                    ->columnStart(['lg' => 3])
                    ->collapsible()
                    ->schema([
                        TextInput::make('contact')
                            ->maxLength(255),
                        TextInput::make('address')
                            ->columnSpan(2)
                            ->maxLength(255),
                ])->columns(2),
                
                Section::make("Submitted by")
                    ->columnSpan(['sm' => 1, 'md' => 2])
                    ->columnSpan(['lg' => 4])
                    ->collapsible()
                    ->schema([
                    TextInput::make('submitted_by')
                        ->maxLength(255),
                    TextInput::make('submitted_by_contact')
                        ->maxLength(255),
                ])->columns(2),
            // TextInput::make('qr_code')
            //     ->maxLength(25),
            // Toggle::make('synced'),
            // Select::make('office_id')
            //     ->relationship('office', 'name'),
            // Select::make('user_id')
            //     ->relationship('user', 'name'),
            // TextInput::make('old_received_by')
            //     ->maxLength(255),
            // TextInput::make('old_serial_no')
            //     ->maxLength(255),
            // TextInput::make('old_declaration_id')
            //     ->maxLength(255),
            // Select::make('staff_id')
            //     ->relationship('staff', 'title')
            //     ->required(),
        ];
    }
}
