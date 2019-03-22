<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSsoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sso_tickets', function (Blueprint $table) {
            $table->comment = 'sso登录票据表';
            $table->increments('id');
            $table->integer('user_id')->comment('user_id');
            $table->string('app_id')->comment('app_id');
            $table->string('ticket')->comment('票据');
            $table->timestamp('expire_at')->comment('到期时间');
            $table->timestamps();
        });

        Schema::create('sso_clients', function (Blueprint $table) {
            $table->comment = 'sso 客户端表';
            $table->increments('id');
            $table->string('app_id')->comment('app_id');
            $table->string('app_secret')->comment('app_secret');
            $table->string('domain')->comment('域名');
            $table->timestamps();
        });

        Schema::create('sso_roles', function (Blueprint $table) {
            $table->comment = 'sso 规则表';
            $table->increments('id');
            $table->string('app_id')->comment('app_id');
            $table->string('allow_app_id')->comment('允许登录的app_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sso_tickets');
        Schema::dropIfExists('sso_clients');
        Schema::dropIfExists('sso_roles');
    }
}
