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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique()->index(); // Indexing wajib untuk scan cepat
            $table->string('name');
            $table->string('brand')->nullable();
            
            // Nutrisi per serving
            $table->string('serving_size')->nullable(); // misal "1 kemasan (200ml)"
            $table->decimal('calories', 8, 2)->default(0);
            
            // Indikator Utama (GGL - Gula Garam Lemak)
            $table->decimal('sugar_g', 8, 2)->default(0); // Gula (gram)
            $table->decimal('salt_mg', 8, 2)->default(0); // Garam/Natrium (mg) - perhatikan satuan
            $table->decimal('fat_total_g', 8, 2)->default(0); // Lemak Total (gram)
            $table->decimal('fat_saturated_g', 8, 2)->default(0); // Lemak Jenuh (gram)
            $table->decimal('protein_g', 8, 2)->default(0);
            $table->decimal('carbo_g', 8, 2)->default(0);
            $table->decimal('cholesterol_mg', 8, 2)->default(0);

            // Grading System
            $table->enum('grade', ['A', 'B', 'C', 'D'])->nullable(); // Hasil algoritma grading Anda
            $table->jsonb('nutri_score_details')->nullable(); // Simpan detail perhitungan score jika perlu
            
            // Meta data
            $table->string('fatsecret_id')->nullable(); // ID referensi dari API luar
            $table->text('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
