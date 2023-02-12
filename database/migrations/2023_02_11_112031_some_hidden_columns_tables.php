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
        Schema::table('events', function (Blueprint $table) {
        $table->boolean("hidden")->default(false);
        });
        Schema::table('events_topics', function (Blueprint $table) {
            $table->boolean("hidden")->default(false);
        });
        Schema::table('studies', function (Blueprint $table) {
            $table->boolean("hidden")->default(false);
        });
        Schema::table('studies_topics', function (Blueprint $table) {
            $table->boolean("hidden")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('hidden');
        });
        Schema::table('events_topics', function (Blueprint $table) {
            $table->dropColumn('hidden');
        });
        Schema::table('studies', function (Blueprint $table) {
            $table->dropColumn('hidden');
        });
        Schema::table('studies_topics', function (Blueprint $table) {
            $table->dropColumn('hidden');
        });
    }
};
