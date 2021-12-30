<?php

namespace App\Domains\Aws\Services;


use ErrorException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AmazonS3Service
{

    /**
     * @param UploadedFile $file
     * @param string $s3filePath
     * @param string $fileName
     * @return string|null
     * @throws ErrorException
     */
    public function upload(UploadedFile $file, string $s3filePath, string $fileName) : ?string
    {
        $appEnv = env('APP_ENV');

        if (!$appEnv) {
            throw new ErrorException("APP_ENV not set");
        }

        $uniqueName = time() . $file->getClientOriginalName();

        $filePath = "{$appEnv}/{$s3filePath}/{$fileName}{$uniqueName}";
        $filePath = $this->normalizeUrl($filePath);


        $s3FullPath = null;

        if (Storage::disk('s3')->put($filePath, file_get_contents($file))) {
            $s3FullPath = add_scheme_to_url($this->normalizeUrl($this->generateS3BaseUrl() . $filePath));
        }

        return $s3FullPath;
    }

    public function normalizeUrl(string $url){
        return str_replace('//', '/', $url); // normalize;
    }


    /**
     * @return string
     * @throws ErrorException
     */
    public function generateS3BaseUrl(){

        $region = env('AWS_DEFAULT_REGION');
        $bucket = env('AWS_BUCKET');

        if (empty($region) || empty($bucket)) {
            throw new ErrorException("S3 environment urls not configured correctly");
        }

        return "s3.{$region}.amazonaws.com/{$bucket}/";
    }
}
