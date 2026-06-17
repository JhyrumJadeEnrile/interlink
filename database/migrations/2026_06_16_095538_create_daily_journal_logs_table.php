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
Schema::create('daily_journal_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
    $table->date('date');
    $table->integer('hours_rendered'); // Ilang oras ang trinabaho sa araw na ito
    $table->text('tasks_done'); // Deskripsyon ng ginawa
    $table->string('status')->default('pending'); // pending, approved, rejected (Supervisor ang magpapalit nito)
    $table->text('supervisor_remarks')->nullable(); // Comment ng professor kung bakit na-reject o may ipapaayos
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_journal_logs');
    }
};
