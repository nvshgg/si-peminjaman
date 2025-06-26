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
        Schema::table('item_loans', function (Blueprint $table) {
            $table->date('start_date')->after('qty');
            $table->date('end_date')->after('start_date');
            $table->dropColumn('loan_date');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_loans', function (Blueprint $table) {
            $table->date('loan_date')->after('qty');
            $table->dropColumn(['start_date','end_date']);
        });

    }
};
