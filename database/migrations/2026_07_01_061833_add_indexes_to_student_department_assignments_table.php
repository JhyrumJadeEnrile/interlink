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
        Schema::table('student_department_assignments', function (Blueprint $table) {
            // Add unique constraint (shortened name for MySQL compatibility)
            $table->unique(['student_id', 'supervisor_id', 'company_id'], 'stu_sup_comp_unique');
            
            // Add indexes for quick lookups
            $table->index(['supervisor_id', 'company_id', 'department'], 'sup_comp_dept_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_department_assignments', function (Blueprint $table) {
            $table->dropUnique('stu_sup_comp_unique');
            $table->dropIndex('sup_comp_dept_idx');
        });
    }
};
