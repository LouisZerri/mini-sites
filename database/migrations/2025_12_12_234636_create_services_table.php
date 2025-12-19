<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained()->onDelete('cascade');
            $table->string('category')->nullable();
            $table->string('titre'); // Ex: "Sourcing & Négociation"
            $table->text('description'); // Description du service
            $table->json('points_forts')->nullable(); // Liste de points forts
            $table->integer('ordre')->default(0); // Pour trier les services
            $table->boolean('actif')->default(true);
            $table->timestamps();
            
            $table->index(['agent_id', 'actif']);
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};