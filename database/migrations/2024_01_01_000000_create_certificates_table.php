<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number')->unique();
            $table->string('student_name');
            $table->string('student_email');
            $table->string('student_phone')->nullable();
            $table->string('course_name');
            $table->string('course_code')->nullable();
            $table->date('course_start_date');
            $table->date('course_end_date');
            $table->integer('course_duration'); // in hours
            $table->string('instructor_name');
            $table->string('grade')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->date('issue_date');
            $table->date('expiry_date')->nullable();
            $table->text('description')->nullable();
            $table->string('certificate_file')->nullable();
            $table->string('verification_code')->unique();
            $table->enum('status', ['active', 'expired', 'revoked'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['certificate_number', 'verification_code']);
            $table->index(['student_email', 'course_code']);
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
};
