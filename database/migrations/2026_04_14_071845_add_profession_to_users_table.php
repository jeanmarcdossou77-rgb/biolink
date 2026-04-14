<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'profession')) {
                $table->string('profession')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'domaine_etude')) {
                $table->string('domaine_etude')->nullable()->after('profession');
            }
            if (!Schema::hasColumn('users', 'pays')) {
                $table->string('pays')->default('Bénin')->after('domaine_etude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profession', 'domaine_etude', 'pays']);
        });
    }
};