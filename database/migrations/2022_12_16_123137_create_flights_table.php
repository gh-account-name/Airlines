<?php

use App\Models\Airplane;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_city_id')->references('id')->on('cities');
            $table->foreignId('to_city_id')->references('id')->on('cities');
            $table->date('dateFrom');
            $table->date('dateTo');
            $table->time('timeFrom');
            $table->time('timeTo');
            $table->time('timeWay');
            $table->float('percentPrice');
            $table->foreignIdFor(Airplane::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('status')->default('готов');
            $table->foreignId('from_airport_id')->references('id')->on('airports');
            $table->foreignId('to_airport_id')->references('id')->on('airports');
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
        Schema::dropIfExists('flights');
    }
};
