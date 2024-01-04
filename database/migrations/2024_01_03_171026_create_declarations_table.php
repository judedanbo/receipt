<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('declarations', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no', 10);
            $table->date('declared_date')->nullable();
            $table->string('name');
            $table->string('post');
            $table->string('schedule')->nullable();
            $table->string('office_location')->nullable();
            $table->text('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('witness')->nullable();
            $table->string('witness_occupation')->nullable();
            $table->string('submitted_by')->nullable();
            $table->string('submitted_by_contact')->nullable();
            $table->string('qr_code', 25, )->nullable();
            $table->boolean('synced')->nullable();
            $table->foreignId('office_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('old_received_by')->nullable();
            $table->string('old_serial_no')->nullable();
            $table->string('old_declaration_id')->nullable();
            $table->foreignId('staff_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('declarations');
    }
};
