<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config('rinvex.pages.tables.pageables'), function (Blueprint $table) {
            // Columns
            $table->integer('page_id')->unsigned();
            $table->morphs('pageable');
            $table->timestamps();

            // Indexes
            $table->unique(['page_id', 'pageable_id', 'pageable_type'], 'pageables_ids_type_unique');
            $table->foreign('page_id')->references('id')->on(config('rinvex.pages.tables.pages'))
                  ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('rinvex.pages.tables.pageables'));
    }
}
