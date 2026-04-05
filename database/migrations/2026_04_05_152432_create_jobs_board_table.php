<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs_board', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('entreprise');
            $table->string('lieu');
            $table->string('type')->default('CDI');
            $table->text('description');
            $table->text('competences');
            $table->string('salaire')->nullable();
            $table->string('email_contact');
            $table->string('categorie')->default('Biologie');
            $table->boolean('approuve')->default(false);
            $table->date('date_expiration')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs_board');
    }
};