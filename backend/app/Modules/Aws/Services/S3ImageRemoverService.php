<?php

namespace App\Modules\Aws\Services;

use App\Modules\Aws\Models\AwsS3Upload;
use Illuminate\Support\Collection;

class S3ImageRemoverService
{

    private AmazonS3Service $s3;

    public function __construct(AmazonS3Service $s3)
    {
        $this->s3 = $s3;
    }

    public function deleteImagesMarkedForDeletion()
    {
        AwsS3Upload::query()->where('status', 'marked_for_deletion')
            ->chunkById(100, function (Collection $uploadedFiles) {
                foreach ($uploadedFiles as $uploadedFile) {
                    if ($this->s3->deleteFileFromS3($uploadedFile->s3_path)) {
                        $uploadedFile->update(['status' => 'deleted']);
                    }
                }
            });
    }
}
