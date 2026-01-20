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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('temp_email_id')->constrained()->onDelete('cascade');
            $table->string('from_email');                   // Кто отправил
            $table->string('subject');                      // Тема письма
            $table->longText('html_content')->nullable();   // HTML письма
            $table->longText('text_content')->nullable();   // Текст письма
            $table->timestamp('received_at');               // Когда пришло
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
