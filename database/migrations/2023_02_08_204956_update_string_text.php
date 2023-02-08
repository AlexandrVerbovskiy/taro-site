<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('areas_activities', function (Blueprint $table) {
            $table->text('body')->change();
        });
        Schema::table('masters', function (Blueprint $table) {
            $table->text('description')->change();
        });
        Schema::table('studies', function (Blueprint $table) {
            $table->text('body')->change();
        });
        Schema::table('infos_posts', function (Blueprint $table) {
            $table->text('body')->change();
        });
        Schema::table('events', function (Blueprint $table) {
            $table->text('body')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('areas_activities', function (Blueprint $table) {
            $table->string('body')->change();
        });
        Schema::table('masters', function (Blueprint $table) {
            $table->string('description')->change();
        });
        Schema::table('studies', function (Blueprint $table) {
            $table->string('body')->change();
        });
        Schema::table('infos_posts', function (Blueprint $table) {
            $table->string('body')->change();
        });
        Schema::table('events', function (Blueprint $table) {
            $table->string('body')->change();
        });
    }
};
