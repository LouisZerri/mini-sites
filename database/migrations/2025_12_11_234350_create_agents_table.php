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
            $table->unsignedInteger('user_id')->nullable();
            $table->string('prenom');
            $table->string('nom');
            $table->string('titre')->nullable(); // Ex: "Expert en Investissement"
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('telephone', 20);
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->text('accroche')->nullable(); // Description courte sous les badges
            $table->text('info_legale')->nullable(); // RSAC, etc.
            $table->text('parcours')->nullable(); // Texte parcours professionnel
            $table->string('secteur');
            $table->string('langues')->default('FR'); // Ex: "FR / EN"
            $table->json('reseaux_sociaux')->nullable();
            $table->boolean('actif')->default(true);
            $table->boolean('disponible')->default(true); // Statut disponibilité

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
