<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Vérifier et ajouter colonne lu dans notifications_biolink
        if (!Schema::hasColumn('notifications_biolink', 'lu')) {
            Schema::table('notifications_biolink', function (Blueprint $table) {
                $table->boolean('lu')->default(false)->after('type');
            });
        }

        // Vérifier et ajouter colonne lu dans messages
        if (!Schema::hasColumn('messages', 'lu')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->boolean('lu')->default(false)->after('contenu');
            });
        }

        // Ajouter colonne photo dans messages si manquante
        if (!Schema::hasColumn('messages', 'photo')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->string('photo')->nullable()->after('lu');
            });
        }
    }

    public function down(): void
    {
        Schema::table('notifications_biolink', function (Blueprint $table) {
            $table->dropColumn('lu');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['lu', 'photo']);
        });
    }
};