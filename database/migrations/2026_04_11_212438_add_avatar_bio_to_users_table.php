<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo_profil')->nullable()->after('avatar');
            $table->text('bio')->nullable()->after('photo_profil');
            $table->string('whatsapp')->nullable()->after('bio');
            $table->integer('amis_count')->default(0)->after('whatsapp');
            $table->integer('abonnes_count')->default(0)->after('amis_count');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo_profil', 'bio', 'whatsapp', 'amis_count', 'abonnes_count']);
        });
    }
};