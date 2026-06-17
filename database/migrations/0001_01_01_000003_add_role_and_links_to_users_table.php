<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'role')) {
            $table->string('role')->default('student');
        }
        if (!Schema::hasColumn('users', 'teacher_id')) {
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
        }
        if (!Schema::hasColumn('users', 'supervisor_id')) {
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->nullOnDelete();
        }
        if (!Schema::hasColumn('users', 'company_name')) {
            $table->string('company_name')->nullable();
        }
        if (!Schema::hasColumn('users', 'department')) {
            $table->string('department')->nullable();
        }
    });
}
};
