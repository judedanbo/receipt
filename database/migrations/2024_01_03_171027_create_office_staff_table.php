<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('office_staff', function (Blueprint $table) {
            $table->foreignId('office_id');
            $table->foreignId('staff_id');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('office_staff');
    }
};
