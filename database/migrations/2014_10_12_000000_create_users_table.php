<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('role_id')->index()->default(3)->comment('1 for Admin or 2 for Teacher and 3 for Student');
            $table->string('address')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('current_school')->nullable();
            $table->string('previous_school')->nullable();
            $table->integer('experience')->nullable();
            $table->json('parent_details')->nullable();
            $table->integer('assigned_teacher')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
