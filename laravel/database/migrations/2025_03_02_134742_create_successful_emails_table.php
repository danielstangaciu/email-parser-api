<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuccessfulEmailsTable extends Migration
{
    public function up()
    {
        Schema::create('successful_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('affiliate_id');
            $table->text('envelope');
            $table->string('from', 255);
            $table->text('subject');
            $table->string('dkim', 255)->nullable();
            $table->string('SPF', 255)->nullable();
            $table->float('spam_score')->nullable();
            $table->longText('email');
            $table->longText('raw_text')->default('');
            $table->string('sender_ip', 50)->nullable();
            $table->text('to');
            $table->integer('timestamp');
            $table->timestamp('deleted_at')->nullable(); // For soft deletes
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('successful_emails');
    }
}
