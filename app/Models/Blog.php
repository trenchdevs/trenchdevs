<?php

namespace App\Models;

use App\Models\Blogs\BlogTag;
use App\User;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    /**
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tags')
            ->withTimestamps();
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

        $minutes = 1; // default to 1 minute

        if (!empty($this->markdown_contents)) {
            $numberOfWords = str_word_count($this->markdown_contents);
            // the average reading speed is 200 to 250 words a minute
            // https://secure.execuread.com/facts/#:~:text=The%20average%20person%20in%20business,roughly%202%20minutes%20per%20page.
            $minutes = intval(ceil($numberOfWords / 200));
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

        $minutesVerbiage = 'minutes';

        if ($minutes < 2) {
            $minutesVerbiage = 'minute';
        }

        return "{$date} · {$minutes} {$minutesVerbiage} read";
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


    /**
     * Returns associate tag entries as csv string
     * @param string $delimiter
     * @return string
     */
    public function getTagsUsingDelimiter($delimiter = ','): string{

        $tagsCsv = '';

        if (!empty($this->tags)) {
            $tagsCsv = $this->tags()
                ->select('tag_name')
                ->get('tag_name')
                ->implode('tag_name', $delimiter);
        }

        return $tagsCsv;
    }
}
