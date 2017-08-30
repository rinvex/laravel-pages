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
    public function up()
    {
        Schema::create(config('rinvex.pages.tables.pages'), function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->string('uri');
            $table->string('slug');
            $table->string('route');
            $table->string('domain')->nullable();
            $table->string('middleware')->nullable();
            $table->{$this->jsonable()}('title');
            $table->{$this->jsonable()}('subtitle')->nullable();
            $table->{$this->jsonable()}('excerpt')->nullable();
            $table->{$this->jsonable()}('content')->nullable();
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
    public function down()
    {
        Schema::dropIfExists(config('rinvex.pages.tables.pages'));
    }

    /**
     * Get jsonable column data type.
     *
     * @return string
     */
    protected function jsonable()
    {
        return DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql'
               && version_compare(DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION), '5.7.8', 'ge')
            ? 'json' : 'text';
    }
}
