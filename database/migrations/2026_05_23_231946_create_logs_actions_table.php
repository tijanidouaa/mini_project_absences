<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('logs_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')
                  ->constrained('utilisateurs')
                  ->onDelete('cascade');
            $table->string('page_visitee', 255);
            $table->dateTime('date_heure');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('logs_actions');
    }
};