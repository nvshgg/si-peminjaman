<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('qty');
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->timestamps();
        });


        // Hapus dulu bila trigger lama masih ada
        DB::unprepared('DROP TRIGGER IF EXISTS trg_items_before_insert;');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_items_before_update;');

        // Trigger sebelum INSERT
        DB::unprepared(<<<'SQL'
            CREATE TRIGGER trg_items_before_insert
            BEFORE INSERT ON items
            FOR EACH ROW
            BEGIN
            IF NEW.qty = 0 THEN
                SET NEW.status = 'unavailable';
            ELSE
                SET NEW.status = 'available';
            END IF;
            END;
            SQL
                    );

                    // Trigger sebelum UPDATE
                    DB::unprepared(<<<'SQL'
            CREATE TRIGGER trg_items_before_update
            BEFORE UPDATE ON items
            FOR EACH ROW
            BEGIN
            IF NEW.qty <> OLD.qty THEN
                IF NEW.qty = 0 THEN
                SET NEW.status = 'unavailable';
                ELSE
                SET NEW.status = 'available';
                END IF;
            END IF;
            END;
            SQL
        );
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
