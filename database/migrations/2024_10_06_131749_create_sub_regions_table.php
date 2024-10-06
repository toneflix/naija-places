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
        Schema::create('sub_regions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // varchar(100)
            $table->json('translations')->nullable(); // text
            $table->foreignId('region_id')->nullable()->constrained('regions')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps(); // created_at and updated_at columns, no precision
            $table->boolean('flag')->default(true);
            $table->string('wikiDataId', 255)->nullable()->comment('Rapid API GeoDB Cities'); // varchar(255) with comment
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_regions');
    }
};
