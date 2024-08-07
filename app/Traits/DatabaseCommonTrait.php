<?php

namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;

trait DatabaseCommonTrait {
    public function commonColumns(Blueprint $table) {

        $table->date('created_date');
        $table->date('updated_date');
        $table->date('deleted_date')->nullable();
    }

    public function commonCharset(Blueprint $table) {
        $table->charset = 'utf8';
        $table->collation = 'utf8_general_ci';
    }
}
