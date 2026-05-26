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
        Schema::table('schedule_volunteers', function (Blueprint $table) {
            $table->unique(['teaching_schedule_id', 'user_id'], 'sched_vol_unique');
        });

        Schema::table('teaching_reports', function (Blueprint $table) {
            $table->unique(['teaching_schedule_id', 'user_id'], 'teach_rep_unique');
        });

        // Drop the constraint attempt that failed or do it safely
        // But since it failed on start_time, the unique constraints might have been created already if Postgres doesn't roll back DDL, but usually it does.
        // I will use DB statement for time casting.
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE teaching_schedules ALTER COLUMN start_time TYPE time without time zone USING start_time::time without time zone');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE teaching_schedules ALTER COLUMN end_time TYPE time without time zone USING end_time::time without time zone');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teaching_schedules', function (Blueprint $table) {
            $table->string('start_time')->change();
            $table->string('end_time')->change();
        });

        Schema::table('teaching_reports', function (Blueprint $table) {
            $table->dropUnique('teach_rep_unique');
        });

        Schema::table('schedule_volunteers', function (Blueprint $table) {
            $table->dropUnique('sched_vol_unique');
        });
    }
};
