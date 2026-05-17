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
        Schema::create('volunteer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('whatsapp')->nullable();
            $table->string('campus_major')->nullable();
            $table->string('domicile')->nullable();
            $table->string('interested_subjects')->nullable();
            $table->string('availability')->nullable();
            $table->text('motivation')->nullable();
            $table->string('ktm_photo')->nullable();
            $table->timestamps();
        });

        Schema::create('learning_homes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->integer('student_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('teaching_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_home_id')->constrained('learning_homes')->onDelete('cascade');
            $table->string('subject');
            $table->date('schedule_date');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('status')->default('scheduled'); // scheduled, completed, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('schedule_volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teaching_schedule_id')->constrained('teaching_schedules')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('attendance_status')->nullable(); // present, absent
            $table->timestamps();
        });

        Schema::create('teaching_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teaching_schedule_id')->constrained('teaching_schedules')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('material_taught');
            $table->integer('student_count')->default(0);
            $table->text('obstacles')->nullable();
            $table->text('evaluation')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_path');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('teaching_reports');
        Schema::dropIfExists('schedule_volunteers');
        Schema::dropIfExists('teaching_schedules');
        Schema::dropIfExists('learning_homes');
        Schema::dropIfExists('volunteer_profiles');
    }
};
