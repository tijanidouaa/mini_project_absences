<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('justifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absence_id')
                  ->constrained('absences')
                  ->onDelete('cascade');
            $table->string('fichier', 255);
            $table->enum('etat', ['en_attente', 'acceptee', 'refusee'])
                  ->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('justifications');
    }
};