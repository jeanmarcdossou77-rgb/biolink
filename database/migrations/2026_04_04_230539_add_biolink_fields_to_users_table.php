<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('sexe')->default('non_precise')->after('email');
            $table->integer('age')->nullable()->after('sexe');
            $table->float('poids')->nullable()->after('age');
            $table->float('taille')->nullable()->after('poids');
            $table->text('etat_sante')->nullable()->after('taille');
            $table->integer('grade_id')->default(1)->after('etat_sante');
            $table->integer('publications_validees')->default(0)->after('grade_id');
            $table->integer('points')->default(0)->after('publications_validees');
            $table->boolean('is_premium')->default(false)->after('points');
            $table->boolean('is_admin')->default(false)->after('is_premium');
            $table->string('avatar')->nullable()->after('is_admin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'sexe', 'age', 'poids', 'taille',
                'etat_sante', 'grade_id', 'publications_validees',
                'points', 'is_premium', 'is_admin', 'avatar'
            ]);
        });
    }
};