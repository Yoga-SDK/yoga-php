<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiTokenToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (config('yoga.auth.api_tokens')) {
            Schema::table(config('yoga.auth.users_table'), function (Blueprint $table) {
                $table->string('api_token', 80)->after('password')
                ->unique()
                ->nullable()
                ->default(null);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (config('yoga.auth.api_tokens')) {
            Schema::table(config('yoga.auth.users_table'), function (Blueprint $table) {
                $table->dropColumn(['api_token']);
            });
        }
    }
}
