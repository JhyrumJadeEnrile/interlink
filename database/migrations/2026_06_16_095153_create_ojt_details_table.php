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
        Schema::create('ojt_details', function (Blueprint $table) {
    $table->id();
    // Foreign key na nakaturo sa id ng users table (dapat student ang role)
    $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
    // Foreign key na nakaturo sa id ng companies table
    $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
    
    $table->integer('required_hours')->default(486); // Halimbawa: 486 hours para sa TUP
    $table->integer('accumulated_hours')->default(0); // Dito dadagdag ang mga aprubadong oras
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ojt_details');
    }
};
