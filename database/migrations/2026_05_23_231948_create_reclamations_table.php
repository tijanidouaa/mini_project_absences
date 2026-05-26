<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reclamations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absence_id')
                  ->constrained('absences')
                  ->onDelete('cascade');
            $table->foreignId('etudiant_id')
                  ->constrained('etudiants')
                  ->onDelete('cascade');
            $table->text('message');
            $table->text('reponse')->nullable();
            $table->enum('etat', ['en_attente', 'traitee'])
                  ->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reclamations');
    }
};