<?php

namespace App\Helpers;


use ErrorException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AmazonS3Helper
{

    /**
     * @param UploadedFile $file
     * @param string $s3filePath
     * @param string $fileName
     * @return bool
     * @throws ErrorException
     */
    public function upload(UploadedFile $file, string $s3filePath, string $fileName) : ?string
    {
        $appEnv = env('APP_ENV');

        if (!$appEnv) {
            throw new ErrorException("APP_ENV not set");
        }

        $name = time() . $file->getClientOriginalName();

        $filePath = "{$appEnv}/{$s3filePath}/{$fileName}/{$name}";
        $filePath = $this->normalizeUrl($filePath);


        $s3FullPath = null;

        if (Storage::disk('s3')->put($filePath, file_get_contents($file))) {
            $s3FullPath = $this->addScheme($this->normalizeUrl($this->generateBaseUrl() . $filePath));
        }

        return $s3FullPath;
    }

    public function normalizeUrl(string $url){
        return str_replace('//', '/', $url); // normalize;
    }

    public function addScheme(string $url, bool $tls = true){

        $scheme = 'https://';

        if (!$tls) {
            $scheme = 'http://';
        }

        $url = $this->normalizeUrl($url);

        return "{$scheme}{$url}";
    }

    /**
     * @return string
     * @throws ErrorException
     */
    public function generateBaseUrl(){

        $region = env('AWS_DEFAULT_REGION');
        $bucket = env('AWS_BUCKET');

        if (empty($region) || empty($bucket)) {
            throw new \ErrorException("S3 environment urls not configured correctly");
        }

        return "s3.{$region}.amazonaws.com/{$bucket}/";
    }
}
