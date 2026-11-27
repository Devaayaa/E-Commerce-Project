<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * withdrawals.courier_id sebelumnya mengacu ke users.id.
     * Sekarang mengacu ke couriers.id (sesuai nama kolomnya).
     */
    public function up(): void
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropForeign(['courier_id']);
        });

        // Konversi data lama: users.id -> couriers.id
        $rows = DB::table('withdrawals')->get(['id', 'courier_id']);
        foreach ($rows as $row) {
            $courierId = DB::table('couriers')->where('user_id', $row->courier_id)->value('id');

            if ($courierId) {
                DB::table('withdrawals')->where('id', $row->id)->update(['courier_id' => $courierId]);
            } else {
                // Tidak ada profil kurir yang cocok -> hapus agar FK baru valid
                DB::table('withdrawals')->where('id', $row->id)->delete();
            }
        }

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->foreign('courier_id')->references('id')->on('couriers')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropForeign(['courier_id']);
        });

        $rows = DB::table('withdrawals')->get(['id', 'courier_id']);
        foreach ($rows as $row) {
            $userId = DB::table('couriers')->where('id', $row->courier_id)->value('user_id');

            if ($userId) {
                DB::table('withdrawals')->where('id', $row->id)->update(['courier_id' => $userId]);
            } else {
                DB::table('withdrawals')->where('id', $row->id)->delete();
            }
        }

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->foreign('courier_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
