<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('temp_user_id')->nullable()->constrained('temp_users')->onUpdate('cascade')->onDelete('cascade');
            $table->morphs('transactable');
            $table->string('reference')->nullable();
            $table->string('method')->nullable();
            $table->decimal('amount')->default(0.00);
            $table->decimal('discount')->default(0.00);
            $table->decimal('due')->default(0.00);
            $table->decimal('tax')->default(0.00);
            $table->decimal('fees')->default(0.00);
            $table->enum('status', ['pending', 'complete', 'rejected'])->default('complete');
            $table->json('webhook')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('transactions');
    }
};