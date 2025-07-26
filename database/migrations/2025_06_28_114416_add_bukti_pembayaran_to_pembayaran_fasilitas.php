<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pembayaran_fasilitas', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable()->after('metode');
            $table->text('catatan_admin')->nullable()->after('bukti_pembayaran');
            $table->string('qr_code')->nullable()->after('catatan_admin');
            $table->timestamp('tanggal_approved')->nullable()->after('qr_code');
        });
    }

    public function down()
    {
        Schema::table('pembayaran_fasilitas', function (Blueprint $table) {
            $table->dropColumn(['bukti_pembayaran', 'catatan_admin', 'qr_code', 'tanggal_approved']);
        });
    }
};
