<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('remedes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->text('ingredients');
            $table->text('preparation');
            $table->string('type')->default('naturel');
            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();
            $table->string('sexe')->default('tous');
            $table->boolean('approuve')->default(false);
            $table->integer('votes')->default(0);
            $table->foreignId('pathologie_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remedes');
    }
};