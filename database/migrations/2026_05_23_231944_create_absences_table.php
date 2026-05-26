<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')
                  ->constrained('etudiants')
                  ->onDelete('cascade');
            $table->foreignId('element_id')
                  ->constrained('elements')
                  ->onDelete('cascade');
            $table->enum('type_seance', ['TD', 'TP', 'Cours', 'Visite']);
            $table->dateTime('date_heure');
            $table->enum('etat', ['non_justifiee', 'justifiee', 'annulee'])
                  ->default('non_justifiee');
            $table->foreignId('enseignant_id')
                  ->constrained('enseignants')
                  ->onDelete('cascade');
            $table->string('annee_academique', 9);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('absences');
    }
};