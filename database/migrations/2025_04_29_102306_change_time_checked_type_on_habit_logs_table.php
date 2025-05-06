<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTimeCheckedTypeOnHabitLogsTable extends Migration
{
    public function up()
    {
        Schema::table('habit_logs', function (Blueprint $table) {
            $table->time('time_checked')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('habit_logs', function (Blueprint $table) {
            $table->dateTime('time_checked')->nullable()->change();
        });
    }
}

