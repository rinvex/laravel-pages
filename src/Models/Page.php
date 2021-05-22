<?php

declare(strict_types=1);

namespace Rinvex\Pages\Models;

use Illuminate\Support\Str;
use Spatie\Sluggable\SlugOptions;
use Rinvex\Support\Traits\HasSlug;
use Rinvex\Support\Traits\Macroable;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Rinvex\Support\Traits\HasTranslations;
use Rinvex\Support\Traits\ValidatingTrait;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Rinvex\Pages\Models\Page.
 *
 * @property int                 $id
 * @property string              $uri
 * @property string              $slug
 * @property string              $route
 * @property string              $domain
 * @property string              $middleware
 * @property array               $title
 * @property array               $subtitle
 * @property array               $excerpt
 * @property array               $content
 * @property string              $view
 * @property bool                $is_active
 * @property int                 $sort_order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereMiddleware($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereView($value)
 * @mixin \Eloquent
 */
class Page extends Model implements Sortable
{
    use HasSlug;
    use Macroable;
    use SoftDeletes;
    use SortableTrait;
    use HasTranslations;
    use ValidatingTrait;

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
        $this->setTable(config('rinvex.pages.tables.pages'));
        $this->mergeRules([
            'uri' => 'required|regex:/^([0-9a-z\/_-]+)$/|max:150|unique:'.config('rinvex.pages.tables.pages').',uri,NULL,id,domain,'.($this->domain ?? 'null'),
            'slug' => 'required|alpha_dash|max:150|unique:'.config('rinvex.pages.tables.pages').',slug,NULL,id,domain,'.($this->domain ?? 'null'),
            'route' => 'required|regex:/^([0-9a-z\._-]+)$/|max:150|unique:'.config('rinvex.pages.tables.pages').',route,NULL,id,domain,'.($this->domain ?? 'null'),
            'domain' => 'nullable|string|strip_tags|max:150',
            'middleware' => 'nullable|string|strip_tags|max:150',
            'title' => 'required|string|strip_tags|max:150',
            'subtitle' => 'nullable|string|strip_tags|max:150',
            'excerpt' => 'nullable|string|max:32768',
            'content' => 'nullable|string|max:262144',
            'view' => 'required|string|strip_tags|max:150',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|max:100000',
        ]);

        app('rinvex.pages.pageables')->each(function ($pageable, $key) {
            $field = Str::plural($key);
            $this->mergeFillable([$field]);
            $this->mergeRules([$field => 'nullable|array']);
        });

        parent::__construct($attributes);
    }

    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasSetMutator($key)
    {
        $method = 'set'.Str::studly($key).'Attribute';

        return method_exists($this, $method) ?: self::hasMacro($method);
    }

    /**
     * Determine if a get mutator exists for an attribute.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasGetMutator($key)
    {
        $method = 'get'.Str::studly($key).'Attribute';

        return method_exists($this, $method) ?: self::hasMacro($method);
    }

    /**
     * Get all attached models of the given class to the page.
     *
     * @param string $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function entries(string $class): MorphToMany
    {
        return $this->morphedByMany($class, 'pageable', config('rinvex.pages.tables.pageables'), 'page_id', 'pageable_id', 'id', 'id');
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
     * Activate the page.
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
