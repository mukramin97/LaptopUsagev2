<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalKeluarTriggerToPerpustakaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER add_tanggal_keluar_trigger
            BEFORE INSERT ON table_perpustakaan
            FOR EACH ROW
            BEGIN
                SET NEW.tanggal_keluar = DATE_ADD(NEW.tanggal_masuk, INTERVAL 1 HOUR);
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_perpustakaan', function (Blueprint $table) {
            //
        });
    }
}
