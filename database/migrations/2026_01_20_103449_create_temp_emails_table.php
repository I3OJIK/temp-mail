<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('temp_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();   // Например: fastfox1234@mailmail312.ru
            $table->string('username');          // Часть до @: fastfox1234
            $table->timestamp('expires_at');     // Когда удалится (через 6 месяцев)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_emails');
    }
};
