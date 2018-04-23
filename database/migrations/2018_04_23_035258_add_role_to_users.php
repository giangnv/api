<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /**
         * Add role to users table
         * Default value: 4 - Voter
         * Admin
         * Moderator
         * Audit_firm
         * Voter
         */
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role_id')->default(4);
        });
    }
}
