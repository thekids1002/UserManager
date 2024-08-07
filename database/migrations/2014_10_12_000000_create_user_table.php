<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\DatabaseCommonTrait;

class CreateUserTable extends Migration
{
    use DatabaseCommonTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('email', 255)->nullable(false);
            $table->string('password',255)->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->bigInteger('group_id');
            $table->date('started_date');
            $table->tinyInteger('position');
            $this->commonColumns($table);
            $this->commonCharset($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
