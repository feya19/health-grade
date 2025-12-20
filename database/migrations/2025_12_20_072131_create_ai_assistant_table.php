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
        Schema::create('ai_assistant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('food_id')->nullable()->constrained('foods'); // Konteks makanan yang dibahas
            
            $table->text('user_prompt'); // Pertanyaan user
            $table->text('ai_response'); // Jawaban dari Fine-tuned LLM
            $table->jsonb('context_data')->nullable(); // Menyimpan data nutrisi JSON saat prompt dikirim
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_assistant');
    }
};
