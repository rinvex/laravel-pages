<?php

declare(strict_types=1);

namespace Rinvex\Pages\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Rinvex\Cacheable\CacheableEloquent;
use Rinvex\Pages\Contracts\PageContract;
use Rinvex\Tenantable\Traits\Tenantable;
use Illuminate\Database\Eloquent\Builder;
use Rinvex\Support\Traits\HasTranslations;
use Rinvex\Support\Traits\ValidatingTrait;
use Spatie\EloquentSortable\SortableTrait;

/**
 * Rinvex\Pages\Models\Page.
 *
 * @property int            $id
 * @property string         $uri
 * @property string         $slug
 * @property string         $route
 * @property string         $domain
 * @property string         $middleware
 * @property array          $title
 * @property array          $subtitle
 * @property array          $excerpt
 * @property array          $content
 * @property string         $view
 * @property bool           $is_active
 * @property int            $sort_order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereMiddleware($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereView($value)
 * @mixin \Eloquent
 */
class Page extends Model implements PageContract, Sortable
{
    use HasSlug;
    use Tenantable;
    use SortableTrait;
    use HasTranslations;
    use ValidatingTrait;
    use CacheableEloquent;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'uri',
        'slug',
        'title',
        'route',
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
        'route' => 'string',
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
            'slug' => 'required|alpha_dash|max:150|unique:'.config('rinvex.pages.tables.pages').',slug,NULL,id,domain,'.($this->domain ?? 'null'),
            'route' => 'required|regex:/^([0-9a-z\._-]+)$/|max:150|unique:'.config('rinvex.pages.tables.pages').',route,NULL,id,domain,'.($this->domain ?? 'null'),
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
        static::validating(function (self $model) {
            if ($model->exists && $model->getSlugOptions()->generateSlugsOnUpdate) {
                $model->generateSlugOnUpdate();
            } elseif (! $model->exists && $model->getSlugOptions()->generateSlugsOnCreate) {
                $model->generateSlugOnCreate();
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
    public function activate()
    {
        $this->update(['is_active' => true]);

        return $this;
    }

    /**
     * Deactivate the page.
     *
     * @return $this
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);

        return $this;
    }
}
