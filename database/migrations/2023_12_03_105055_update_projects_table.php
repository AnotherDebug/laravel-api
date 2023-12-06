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
        Schema::table('projects', function (Blueprint $table) {
            //Nuova colonna
            $table->unsignedBigInteger('type_id')->after('id')->nullable();

            //Foreign key
            $table->foreign('type_id')
            ->references('id')
            ->on('types')
            ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {

            //Elimino la foreign key
            $table->dropForeign(['type_id']);

            //Elimino la colonna della foreign key
            $table->dropColumn('type_id');
        });
    }
};
