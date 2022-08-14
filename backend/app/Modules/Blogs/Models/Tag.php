<?php

namespace App\Modules\Blogs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Throwable;

/**
 * Class Tag
 * @property $tag_name
 * @property $id
 *
 * @property $blogs
 * @package App\Models
 */
class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'tag_name',
    ];

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_tags')
            ->withTimestamps();
    }

    /**
     * @param string $name
     * @return Tag
     */
    public static function findByName(string $name): Tag
    {
        /** @var Tag $tag */
        $tag = self::query()->where('tag_name', $name)
            ->first();
        return $tag;
    }

    /**
     * @param string $name
     * @return Tag
     * @throws Throwable
     */
    public static function findOrNewByName(string $name): Tag {

        $tag = self::findByName($name);

        if (!empty($tag)) {
            return $tag;
        }

        $tag = new Tag;
        $tag->tag_name = trim($name);
        $tag->saveOrFail();
        return $tag;
    }

}
