<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pathologies', function (Blueprint $table) {
            $table->text('cause')->nullable()->after('symptomes');
            $table->text('prevention')->nullable()->after('cause');
            $table->text('traitement_naturel')->nullable()->after('prevention');
            $table->string('gravite')->default('modérée')->after('traitement_naturel');
            $table->string('contagieux')->default('non')->after('gravite');
        });
    }

    public function down(): void
    {
        Schema::table('pathologies', function (Blueprint $table) {
            $table->dropColumn([
                'cause',
                'prevention',
                'traitement_naturel',
                'gravite',
                'contagieux'
            ]);
        });
    }
};