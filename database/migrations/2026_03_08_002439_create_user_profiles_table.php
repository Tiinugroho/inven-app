<?php

// database/migrations/xxxx_xx_xx_create_user_profiles_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            $table->string('nik', 50)->unique()->comment('Nomor Induk Karyawan');
            $table->string('phone_number', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('identity_number', 50)->nullable()->comment('No KTP');
            
            // Kontak Darurat (Standar HR)
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();
            
            // Status Kekaryawanan
            $table->date('join_date')->nullable();
            $table->date('resign_date')->nullable();
            $table->string('photo_path')->nullable(); // Path foto profil
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
