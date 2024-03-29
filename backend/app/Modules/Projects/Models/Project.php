<?php

namespace App\Modules\Projects\Models;

use App\Modules\Users\Models\ProjectUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Project
 * @property $user_id
 * @property $title
 * @property $url
 * @property $repository_url
 * @property $image_url
 * @property $created_at
 * @property $updated_at
 * @package App\Models\Projects
 */
class Project extends Model
{

    protected $table = 'projects';

    protected $fillable = [
        'user_id',
        'is_personal',
        'title',
        'url',
        'repository_url',
        'image_url',
    ];

    public function projectUsers(): HasMany
    {
        return $this->hasMany(ProjectUser::class);
    }

    /**
     * @return Builder[]|Collection
     */
    public static function getGlobalProjects(): Collection|array
    {
        return self::query()->where('is_personal', 0)
            ->orderBy('id', 'desc')
            ->get();
    }
}
