<?php

namespace App\Modules\Aws\Services;


use App\Modules\Aws\Models\AwsS3Upload;
use ErrorException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AmazonS3Service
{

    /**
     * @param string $identifier <domain::identifier> e.g. user::profile_avatar
     * @param UploadedFile $file
     * @param string $s3filePath
     * @param string $fileName
     * @param array $meta
     * @return AwsS3Upload|null
     * @throws ErrorException
     */
    public function upload(string $identifier, UploadedFile $file, string $s3filePath, string $fileName, array $meta = []): ?AwsS3Upload
    {
        $appEnv = app()->environment();

        if (!$appEnv) {
            throw new ErrorException("APP_ENV not set");
        }

        $originalName = $file->getClientOriginalName();
        $hash         = md5(time() . $originalName . $fileName);

        $filePath = "{$appEnv}/$s3filePath/$hash";
        $filePath = $this->normalizeUrl($filePath);

        $uploadedFile = null;

        if (Storage::disk('s3')->put($filePath, file_get_contents($file))) {
            $s3FullPath = add_scheme_to_url($this->normalizeUrl($this->generateS3BaseUrl() . $filePath), true);
            /** @var AwsS3Upload $uploadedFile */
            $uploadedFile = AwsS3Upload::query()->create([
                's3_url'     => $s3FullPath,
                's3_path'    => $filePath,
                'status'     => AwsS3Upload::DB_STATUS_UPLOADED,
                'identifier' => $identifier,
                'meta'       => json_encode(array_merge([
                    'original_name' => $originalName,
                    'environment'   => $appEnv,
                    'size' => $file->getSize(),
                ], $meta)),
            ]);
        }

        return $uploadedFile;
    }

    /**
     * @param string $url
     * @return array|string
     */
    private function normalizeUrl(string $url): array|string
    {
        return str_replace('//', '/', $url); // normalize;
    }

    /**
     * Delete an object from S3
     * @param string $s3Url
     * @return bool
     */
    public function deleteFileFromS3(string $s3Url): bool
    {
        return Storage::disk('s3')->delete($s3Url);
    }

    /**
     * @param string $s3Url
     * @return int
     */
    public function markForDeletion(string $s3Url): int
    {
        return AwsS3Upload::query()
            ->where('s3_url', '=', $s3Url)
            ->where('status', '=', 'uploaded')
            ->update(['status' => 'marked_for_deletion']);
    }


    /**
     * @return string
     * @throws ErrorException
     */
    private function generateS3BaseUrl(): string
    {

        $region = env('AWS_DEFAULT_REGION');
        $bucket = env('AWS_BUCKET');

        if (empty($region) || empty($bucket)) {
            throw new ErrorException("S3 environment urls not configured correctly");
        }

        return "s3.{$region}.amazonaws.com/{$bucket}/";
    }
}
