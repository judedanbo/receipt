<?php

namespace App\Models;

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
}
