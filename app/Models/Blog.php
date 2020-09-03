<?php

namespace App\Models;

use App\Models\Blogs\BlogTag;
use App\User;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 * @property $tags
 * @property User $user
 * @property $title
 * @property $moderation_status
 * @property $created_at
 * @property $markdown_contents
 * @property $slug
 * @property $publication_date
 * @package App\Models
 */
class Blog extends Model
{
    protected $table = 'blogs';

    const DB_STATUS_DRAFT = 'draft';
    const DB_STATUS_PUBLISHED = 'published';

    const DB_MODERATION_STATUS_PENDING = 'pending';
    const DB_MODERATION_STATUS_APPROVED = 'approved';
    const DB_MODERATION_STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'tagline',
        'markdown_contents',
        'status',
        'primary_image_url',
        'publication_date',

        'moderation_status',
        'moderated_by',
        'moderated_at',
        'moderation_notes',
    ];

    public function tags()
    {
        $this->hasMany(BlogTag::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return int
     */
    public function getEstimatedNumberOfMinutesToRead(): int
    {

        $minutes = 1;

        if (!empty($this->markdown_contents)) {
            $numberOfWords = str_word_count($this->markdown_contents);
            // on avg: 300 words per minute
            $minutes = $numberOfWords / 300;
        }

        if ($minutes < 1) {
            $minutes = 1;
        }

        return $minutes;
    }

    /**
     * @param string $slug
     * @return Blog|Builder|Model|object
     */
    public static function findPublishedBySlug(string $slug)
    {
        return self::query()
            ->where('slug', $slug)
            ->where('status', self::DB_STATUS_PUBLISHED)
            ->where('moderation_status', self::DB_MODERATION_STATUS_APPROVED)
            ->where('publication_date', '<=', mysql_now())
            ->whereNotNull('publication_date')
            ->first();
    }

    /**
     * We want: February 01, 2020 . 5 min read
     * @return string
     */
    public function getDateMeta(): string
    {

        $date = date("F j, Y", strtotime($this->publication_date));
        $minutes = $this->getEstimatedNumberOfMinutesToRead();

        return "{$date} - {$minutes} min read";
    }

    /**
     * @return mixed
     */
    public function markdownContentsAsHtml()
    {
        return Markdown::convertToHtml($this->markdown_contents);
    }


    /**
     * Get public blog url
     * @return string
     */
    public function getPublicUrl()
    {

        $baseUrl = env('BASE_URL');
        $environment = env('APP_ENV');

        $scheme = $environment === 'production' ? 'https://' : 'http://';

        return "{$scheme}blog.{$baseUrl}/{$this->slug}";
    }

}
