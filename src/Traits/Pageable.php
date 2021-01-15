<?php

declare(strict_types=1);

namespace Rinvex\Pages\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Pageable
{
    /**
     * Register a saved model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    abstract public static function saved($callback);

    /**
     * Register a deleted model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    abstract public static function deleted($callback);

    /**
     * Define a polymorphic many-to-many relationship.
     *
     * @param string $related
     * @param string $name
     * @param string $table
     * @param string $foreignPivotKey
     * @param string $relatedPivotKey
     * @param string $parentKey
     * @param string $relatedKey
     * @param bool   $inverse
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    abstract public function morphToMany(
        $related,
        $name,
        $table = null,
        $foreignPivotKey = null,
        $relatedPivotKey = null,
        $parentKey = null,
        $relatedKey = null,
        $inverse = false
    );

    /**
     * Get all attached pages to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function pages(): MorphToMany
    {
        return $this->morphToMany(config('rinvex.pages.models.page'), 'pageable', config('rinvex.pages.tables.pageables'), 'pageable_id', 'page_id')
                    ->orderBy('sort_order')
                    ->withTimestamps();
    }

    /**
     * Boot the pageable trait for the model.
     *
     * @return void
     */
    public static function bootPageable()
    {
        static::deleted(function (self $model) {
            $model->pages()->detach();
        });
    }

    /**
     * Attach the given page(s) to the model.
     *
     * @param mixed $pages
     *
     * @return void
     */
    public function setPagesAttribute($pages): void
    {
        static::saved(function (self $model) use ($pages) {
            $model->syncPages($pages);
        });
    }

    /**
     * Scope query with all the given pages.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mixed                                 $pages
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAllPages(Builder $builder, $pages): Builder
    {
        collect($pages)->each(function ($page) use ($builder) {
            $builder->whereHas('pages', function (Builder $builder) use ($page) {
                return $builder->where('id', $page);
            });
        });

        return $builder;
    }

    /**
     * Scope query with any of the given pages.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mixed                                 $pages
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAnyPages(Builder $builder, $pages): Builder
    {
        return $builder->whereHas('pages', function (Builder $builder) use ($pages) {
            $builder->whereIn('id', $pages);
        });
    }

    /**
     * Scope query without any of the given pages.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mixed                                 $pages
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutPages(Builder $builder, $pages): Builder
    {
        return $builder->whereDoesntHave('pages', function (Builder $builder) use ($pages) {
            $builder->whereIn('id', $pages);
        });
    }

    /**
     * Scope query without any pages.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutAnyPages(Builder $builder): Builder
    {
        return $builder->doesntHave('pages');
    }

    /**
     * Determine if the model has any of the given pages.
     *
     * @param mixed $pages
     *
     * @return bool
     */
    public function hasAnyPages($pages): bool
    {
        return ! $this->pages->pluck('id')->intersect($pages)->isEmpty();
    }

    /**
     * Determine if the model has all of the given pages.
     *
     * @param mixed $pages
     *
     * @return bool
     */
    public function hasAllPages($pages): bool
    {
        return collect($pages)->diff($this->pages->pluck('id'))->isEmpty();
    }

    /**
     * Attach model pages.
     *
     * @param mixed $pages
     *
     * @return $this
     */
    public function attachPages($pages)
    {
        // Use 'sync' not 'attach' to avoid Integrity constraint violation
        $this->pages()->sync($pages, false);

        return $this;
    }

    /**
     * Sync model pages.
     *
     * @param mixed $pages
     * @param bool  $detaching
     *
     * @return $this
     */
    public function syncPages($pages, bool $detaching = true)
    {
        $this->pages()->sync($pages, $detaching);

        return $this;
    }

    /**
     * Detach model pages.
     *
     * @param mixed $pages
     *
     * @return $this
     */
    public function detachPages($pages = null)
    {
        $this->pages()->detach($pages);

        return $this;
    }
}
