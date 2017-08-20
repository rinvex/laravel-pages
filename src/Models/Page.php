<?php

declare(strict_types=1);

namespace Rinvex\Pages\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\EloquentSortable\Sortable;
use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\Model;
use Rinvex\Cacheable\CacheableEloquent;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Rinvex\Support\Traits\UniqueInjector;
use Spatie\EloquentSortable\SortableTrait;

class Page extends Model implements Sortable
{
    use HasSlug;
    use SortableTrait;
    use HasTranslations;
    use CacheableEloquent;
    use ValidatingTrait, UniqueInjector
    {
        UniqueInjector::prepareUniqueRule insteadof ValidatingTrait;
    }

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'uri',
        'slug',
        'title',
        'subtitle',
        'domain',
        'middleware',
        'excerpt',
        'content',
        'view',
        'is_active',
        'sort_order',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'uri' => 'string',
        'slug' => 'string',
        'domain' => 'string',
        'middleware' => 'string',
        'view' => 'string',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected $observables = [
        'validating',
        'validated',
    ];

    /**
     * {@inheritdoc}
     */
    public $translatable = [
        'title',
        'subtitle',
        'excerpt',
        'content',
    ];

    /**
     * {@inheritdoc}
     */
    public $sortable = [
        'order_column_name' => 'sort_order',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('rinvex.pages.tables.pages'));
        $this->setRules([
            'uri' => 'required|regex:/^([0-9a-z\/_-]+)$/|max:150|unique:'.config('rinvex.pages.tables.pages').',uri,NULL,id,domain,'.($this->domain ?? 'null'),
            'slug' => 'required|regex:/^([0-9a-z\._-]+)$/|max:150|unique:'.config('rinvex.pages.tables.pages').',slug,NULL,id,domain,'.($this->domain ?? 'null'),
            'domain' => 'nullable|string|max:150',
            'middleware' => 'nullable|string|max:150',
            'title' => 'required|string|max:150',
            'subtitle' => 'nullable|string|max:150',
            'excerpt' => 'nullable|string|max:10000',
            'content' => 'nullable|string|max:10000000',
            'view' => 'required|string|max:150',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|max:10000000',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();

        // Auto generate slugs early before validation
        static::registerModelEvent('validating', function (self $attribute) {
            if (! $attribute->slug) {
                if ($attribute->exists && $attribute->getSlugOptions()->generateSlugsOnUpdate) {
                    $attribute->generateSlugOnUpdate();
                } elseif (! $attribute->exists && $attribute->getSlugOptions()->generateSlugsOnCreate) {
                    $attribute->generateSlugOnCreate();
                }
            }
        });
    }

    /**
     * Get the active pages.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
    }

    /**
     * Get the inactive pages.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive(Builder $builder): Builder
    {
        return $builder->where('is_active', false);
    }

    /**
     * Set the translatable title attribute.
     *
     * @param string $value
     *
     * @return void
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = json_encode(! is_array($value) ? [app()->getLocale() => $value] : $value);
    }

    /**
     * Set the translatable subtitle attribute.
     *
     * @param string $value
     *
     * @return void
     */
    public function setSubtitleAttribute($value)
    {
        $this->attributes['subtitle'] = ! empty($value) ? json_encode(! is_array($value) ? [app()->getLocale() => $value] : $value) : null;
    }

    /**
     * Set the translatable excerpt attribute.
     *
     * @param string $value
     *
     * @return void
     */
    public function setExcerptAttribute($value)
    {
        $this->attributes['excerpt'] = ! empty($value) ? json_encode(! is_array($value) ? [app()->getLocale() => $value] : $value) : null;
    }

    /**
     * Set the translatable content attribute.
     *
     * @param string $value
     *
     * @return void
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = ! empty($value) ? json_encode(! is_array($value) ? [app()->getLocale() => $value] : $value) : null;
    }

    /**
     * Get the options for generating the slug.
     *
     * @return \Spatie\Sluggable\SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->doNotGenerateSlugsOnUpdate()
                          ->generateSlugsFrom('title')
                          ->saveSlugsTo('slug');
    }

    /**
     * Active the page.
     *
     * @return $this
     */
    public function activate(): self
    {
        $this->update(['is_active' => true]);

        return $this;
    }

    /**
     * Deactivate the page.
     *
     * @return $this
     */
    public function deactivate(): self
    {
        $this->update(['is_active' => false]);

        return $this;
    }
}
