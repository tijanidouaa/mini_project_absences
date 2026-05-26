<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('historique_modifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')
                  ->constrained('etudiants')
                  ->onDelete('cascade');
            $table->foreignId('utilisateur_id')
                  ->constrained('utilisateurs')
                  ->onDelete('cascade');
            $table->string('champ_modifie', 100);
            $table->text('ancienne_valeur');
            $table->text('nouvelle_valeur');
            $table->dateTime('date_modification');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('historique_modifications');
    }
};