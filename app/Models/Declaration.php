<?php

namespace App\Models;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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


    public function sync(): void{
        //  TODO implement sync declaration
        // $this->;
    }

    public static function getForm(): array {
        return [
            Grid::make([
                'default' => 1,
                'md' => 3,
                'lg' => 4,
                'xl' => 6,
            ])->schema([
                DatePicker::make('declared_date')
                    ->default(now())
                    ->native(false)
                    ->columnStart([ 'md' => 3, 'lg' => 4, 'xl' => 6 ])
                    // ->columnSpan()
                    ,
                Section::make('Declarant Name')
                    // ->columnSpan(['2xl' => 4])
                    // ->columnSpan(['sm' => 2, 'md' => 3, 'xl' => 2])
                    ->schema([
                        TextInput::make('name')
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255),
                    ]),
                Section::make("Post / Schedule")
                    ->columns([ 'md' => 2, 'xl' => 3,  ])
                    ->columnSpan([ 'md' => 3, 'lg' => 2, 'xl' => 3, ])
                    ->schema([
                        TextInput::make('post')
                            ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2, 'xl' => 4, ])
                            ->required()
                            ->maxLength(255),
                        TextInput::make('schedule')
                            ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2, 'xl' => 4,])
                            ->maxLength(255),
                        TextInput::make('office_location')
                        ->columnSpan(['sm' => 2, 'lg' => 3, 'xl' => 4, ])
                            ->maxLength(255),
                    ]),
                
                Section::make('Contact Address')
                    // ->columns(['sm' => 2, 'md' => 4])
                    ->columnSpan(['sm' => 2, 'md' => 3, 'lg' => 2, 'xl' => 3,  ])
                    ->schema([
                        TextInput::make('contact')
                            ->columnSpan(['default' => 1, 'sm' => 2, 'xl' => 2])
                            ->maxLength(255),
                        Textarea::make('address')
                            ->columnSpan(['default' => 1, 'sm' => 2, 'xl' => 2])
                            ->maxLength(255),
                    ]),
                Section::make('Witness')
                    // ->columns(['sm' => 2, 'md' => 2,])
                    ->columnSpan(['sm' => 2,  'lg' => 2,  'xl' => 3])
                    ->schema([
                        TextInput::make('witness')
                                ->columnSpan(['default' => 1, 'sm' => 2, 'xl' => 4])
                            ->maxLength(255),
                        TextInput::make('witness_occupation')
                                ->columnSpan(['default' => 1, 'sm' => 2, 'xl' => 4])
                            ->maxLength(255),
                    ]),
                Section::make('Submitted by')
                    // ->columns(['sm' => 2, 'md' => 3, 'xl' => 1])
                    ->columnSpan(['sm' => 2, 'md' => 1, 'lg' => 2,  'xl' => 3,  ])
                    ->schema([
                        TextInput::make('submitted_by')
                            ->columnSpan(['default' => 1, 'sm' => 2, 'xl' => 4])
                            ->maxLength(255),
                        TextInput::make('submitted_by_contact')
                            ->columnSpan(['default' => 1, 'sm' => 2, 'xl' => 4])
                            ->maxLength(255),
                    ]),
                ])
                ];
    }
}
