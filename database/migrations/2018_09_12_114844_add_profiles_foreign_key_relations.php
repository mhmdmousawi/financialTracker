<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfilesForeignKeyRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function(Blueprint $table) {
            $table->index('id');
            $table->foreign('id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function(Blueprint $table) {
            $table->dropForeign('profiles_id_foreign');
            $table->dropIndex('profiles_id_index');
        });
    }
}
