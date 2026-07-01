<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create table to track student-supervisor-department assignments
     * This ensures students can only time in/out at their assigned department
     * under their assigned supervisor
     */
    public function up(): void
    {
        Schema::create('student_department_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('supervisor_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();
            $table->string('department'); // Department name assigned by teacher
            $table->text('notes')->nullable();
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamps();

            // Composite unique constraint (shortened name for MySQL compatibility)
            $table->unique(['student_id', 'supervisor_id', 'company_id'], 'stu_sup_comp_unique');
            
            // Indexes for quick lookups
            $table->index(['supervisor_id', 'company_id', 'department'], 'sup_comp_dept_idx');
            $table->index(['student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_department_assignments');
    }
};
