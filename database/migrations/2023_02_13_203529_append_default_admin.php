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
        DB::table('users')->insert(
            array(
                'first_name'=>'admin',
                'last_name'=>'admin',
                'phone'=>'admin_phone',
                'email' => 'jwa67m8ui5@gmail.com',
                'password' => bcrypt('qw1reet34qw31'),
                'admin'=>true
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
