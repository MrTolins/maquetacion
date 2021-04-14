<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('age');
            $table->string('email');
            $table->string('address');
            $table->decimal('credit', 6, 2);
            $table->date('date');
            $table->boolean('active');
            $table->timestamps('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_clients');
    }
}
