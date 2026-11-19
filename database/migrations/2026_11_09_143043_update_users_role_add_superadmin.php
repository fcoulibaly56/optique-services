<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // Dans le fichier de migration
public function up()
{
    DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('client', 'opticien', 'admin', 'superadmin') DEFAULT 'client'");
}
public function down()
{
    DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('client', 'opticien', 'admin') DEFAULT 'client'");
}
};
