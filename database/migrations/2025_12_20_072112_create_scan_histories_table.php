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
        Schema::create('scan_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('food_id')->constrained('foods')->onDelete('cascade');
            
            $table->integer('quantity')->default(1); // Jumlah serving yang dikonsumsi/discan
            $table->decimal('total_calories_intaken', 8, 2); // Snapshot kalori saat itu (food.cal * qty)
            
            // Untuk membedakan sekedar "Cek Barcode" atau "Makan"
            $table->enum('action_type', ['scan_only', 'consumed'])->default('scan_only');
            
            $table->timestamps(); // created_at adalah waktu scan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_histories');
    }
};
