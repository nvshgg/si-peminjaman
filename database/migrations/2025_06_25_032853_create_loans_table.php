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
        Schema::create('item_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id');
            $table->foreignId('user_id');
            $table->integer('qty');
            $table->date('loan_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_loans');
    }
};
