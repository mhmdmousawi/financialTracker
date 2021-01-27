<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionsForeignKeyRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function(Blueprint $table) {
            
            $table->index('profile_id');
            $table->foreign('profile_id')
                  ->references('id')
                  ->on('profiles')
                  ->onDelete('cascade');

            $table->index('currency_id');
            $table->foreign('currency_id')
                  ->references('id')
                  ->on('currencies');

            $table->index('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->index('repeat_id');
            $table->foreign('repeat_id')
                ->references('id')
                ->on('repeats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function(Blueprint $table) {
            
            $table->dropForeign('transactions_profile_id_foreign');
            $table->dropIndex('transactions_profile_id_index');

            $table->dropForeign('transactions_currency_id_foreign');
            $table->dropIndex('transactions_currency_id_index');

            $table->dropForeign('transactions_category_id_foreign');
            $table->dropIndex('transactions_category_id_index');

            $table->dropForeign('transactions_repeat_id_foreign');
            $table->dropIndex('transactions_repeat_id_index');
        });
    }
}
