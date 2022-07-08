<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_device', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zoom_id')->nullable();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->foreign('zoom_id')->references('id')->on('zoom')
                ->onDelete('cascade');
            $table->foreign('device_id')->references('id')->on('devices')
                ->onDelete('cascade');
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
        Schema::dropIfExists('room_device');
    }
}
