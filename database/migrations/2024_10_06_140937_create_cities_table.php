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
        Schema::create('world_cities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // varchar(255)
            $table->foreignId('state_id')->nullable()->constrained('world_states')->onUpdate('cascade')->onDelete('cascade');
            $table->string('state_code', 255); // varchar(255)
            $table->foreignId('country_id')->nullable()->constrained('countries')->onUpdate('cascade')->onDelete('cascade');
            $table->char('country_code', 2); // char(2)
            $table->decimal('latitude', 10, 8); // decimal(10,8) NOT NULL
            $table->decimal('longitude', 11, 8); // decimal(11,8) NOT NULL
            $table->timestamps();
            $table->tinyInteger('flag')->default(1); // tinyint(1) NOT NULL DEFAULT '1'
            $table->string('wikiDataId', 255)->nullable()->comment('Rapid API GeoDB Cities'); // varchar(255) with comment
        });
    }
    // (1,'Andorra la Vella',488,'07',6,'AD',42.50779000,1.52109000,'2019-10-05 22:28:06','2019-10-05 22:28:06',1,'Q1863')
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('world_cities');
    }
};
