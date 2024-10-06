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
        Schema::create('world_states', function (Blueprint $table) {
            $table->id(); // mediumint unsigned AUTO_INCREMENT PRIMARY KEY
            $table->string('name', 255); // varchar(255)
            $table->foreignId('country_id')->nullable()->constrained('countries')->onUpdate('cascade')->onDelete('cascade');
            $table->char('country_code', 2); // char(2)
            $table->string('fips_code', 255)->nullable(); // varchar(255), nullable
            $table->string('iso2', 255)->nullable(); // varchar(255), nullable
            $table->string('type', 191)->nullable(); // varchar(191), nullable
            $table->decimal('latitude', 10, 8)->nullable(); // decimal(10,8), nullable
            $table->decimal('longitude', 11, 8)->nullable(); // decimal(11,8), nullable
            $table->timestamps();
            $table->tinyInteger('flag')->default(1); // tinyint(1) NOT NULL DEFAULT '1'
            $table->string('wikiDataId', 255)->nullable()->comment('Rapid API GeoDB Cities'); // varchar(255) with comment
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('world_states');
    }
};
