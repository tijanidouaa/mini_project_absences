<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('demandes_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')
                  ->constrained('etudiants')
                  ->onDelete('cascade');
            $table->foreignId('enseignant_id')
                  ->constrained('enseignants')
                  ->onDelete('cascade');
            $table->text('message');
            $table->enum('reponse', ['OK', 'Non'])->nullable();
            $table->enum('etat', ['en_attente', 'traitee'])
                  ->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('demandes_permission');
    }
};