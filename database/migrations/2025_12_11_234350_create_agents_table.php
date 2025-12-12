<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom');
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('telephone', 20);
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->string('secteur');
            $table->json('reseaux_sociaux')->nullable();
            $table->boolean('actif')->default(true);
            $table->string('couleur_primaire')->default('#1e40af');
            $table->string('couleur_secondaire')->default('#3b82f6');
            $table->timestamps();

            $table->index('slug');
            $table->index('actif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
