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
        Schema::table('infos', function (Blueprint $table) {
            $table->boolean("hidden")->default(false);
        });
        Schema::table('infos_posts', function (Blueprint $table) {
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
        Schema::table('infos', function (Blueprint $table) {
            $table->dropColumn('hidden');
        });
        Schema::table('infos_posts', function (Blueprint $table) {
            $table->dropColumn('hidden');
        });
    }
};
