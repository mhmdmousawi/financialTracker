<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoriesForeignKeyRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function(Blueprint $table) {
            
            $table->index('profile_id');
            $table->foreign('profile_id')
                  ->references('id')
                  ->on('profiles')
                  ->onDelete('cascade');

            $table->index('logo_id');
            $table->foreign('logo_id')
                ->references('id')
                ->on('logos')
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
        Schema::table('categories', function(Blueprint $table) {
            
            $table->dropForeign('categories_profile_id_foreign');
            $table->dropIndex('categories_profile_id_index');

            $table->dropForeign('categories_logo_id_foreign');
            $table->dropIndex('categories_logo_id_index');
        });
    }
}
