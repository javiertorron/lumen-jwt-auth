<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserCreateTable extends Migration
{
    /**
     * Creation for the users table
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 15);
            $table->string('hash');
            $table->timestamps();
        });
    }

    /**
     * Drop the users table
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
