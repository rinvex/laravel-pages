<?php

declare(strict_types=1);

namespace Rinvex\Pages\Contracts;

/**
 * Rinvex\Pages\Contracts\PageContract.
 *
 * @property int            $id
 * @property string         $uri
 * @property string         $slug
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
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page whereView($value)
 * @mixin \Eloquent
 */
interface PageContract
{
    //
}
