<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config('rinvex.pages.tables.pages'), function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->string('uri');
            $table->string('slug');
            $table->string('route');
            $table->string('domain')->nullable();
            $table->json('middleware')->nullable();
            $table->json('title');
            $table->json('subtitle')->nullable();
            $table->json('excerpt')->nullable();
            $table->json('content')->nullable();
            $table->string('view');
            $table->boolean('is_active')->default(true);
            $table->mediumInteger('sort_order')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->unique(['domain', 'uri']);
            $table->unique(['domain', 'slug']);
            $table->unique(['domain', 'route']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('rinvex.pages.tables.pages'));
    }
}
