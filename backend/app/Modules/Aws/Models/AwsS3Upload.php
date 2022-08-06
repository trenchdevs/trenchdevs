<?php

namespace App\Modules\Aws\Models;

use App\Modules\Aws\Services\AmazonS3Service;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $s3_url
 * @property $s3_path
 * @property $identifier
 * @property $status
 * @property $meta
 */
class AwsS3Upload extends Model
{
    protected $table = 'aws_s3_uploads';

    const DB_STATUS_UPLOADED = 'uploaded';

    protected $fillable = [
        "s3_url",
        "s3_path",
        "identifier",
        "status",
        "meta",
    ];

    public function markForRemoval(): int
    {
        return (new AmazonS3Service())->markForDeletion($this->s3_url);
    }


}
