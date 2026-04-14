<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pathologies', 'vues')) {
            Schema::table('pathologies', function (Blueprint $table) {
                $table->integer('vues')->default(0)->after('approuve');
            });
        }
    }

    public function down(): void
    {
        Schema::table('pathologies', function (Blueprint $table) {
            $table->dropColumn('vues');
        });
    }
};