<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_message_delete_at', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('message_id');
            $table->foreign('message_id')->references('id')->on('group_messages');
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('group_messages');
            $table->bigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('group_messages');
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_message_delete_at');
    }
};
