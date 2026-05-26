<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('filieres', function (Blueprint $table) {
            $table->id();
            $table->string('alias', 20);
            $table->string('intitule', 200);
            $table->year('annee_accreditation');
            $table->year('annee_fin_accreditation');
            $table->foreignId('coordonnateur_id')->nullable()->constrained('enseignants')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('filieres'); }
};