<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->comment('User that created the notification');
            $table->unsignedBigInteger('recipient')->comment('User that will receive the notification');
            $table->text('title')->comment('Notification title');
            $table->text('message')->comment('Notification message');
            $table->boolean('read')->default(false);
            $table->timestamps();

            // create an index on the `recipient` field to improve notifications-by-recipient search
            $table->index(['recipient']);

            /**
             * create a foreign keys to the table users. we are assuming that, if the user that created the notification, or the recipient
             * user are deleted, the notification will be deleted too (cascade delete)
             */
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('recipient')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
