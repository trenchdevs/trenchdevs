<?php

namespace App\Modules\Sites\Services;

use App\Modules\Sites\Models\SiteAccessLog;
use ErrorException;
use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class SiteAccessLogsArchiverService
{

    /**
     * @var Filesystem
     */
    private Filesystem $client;

    const  STORAGE_NAME = 's3-archives'; // config/filesystems

    public function __construct()
    {
        $this->client = Storage::disk(self::STORAGE_NAME);
    }


    /**
     * @param int $chunkSize
     * @throws ErrorException
     * @throws Exception
     */
    public function process(int $chunkSize = 1000): void
    {

        if ($chunkSize > 1000) { // hard limit to 1k
            $chunkSize = 1000;
        }

        // Chunk site access logs
        $logs = SiteAccessLog::query()
            ->select('*')
            ->orderBy('created_at', 'ASC')
            ->limit($chunkSize)
            ->get()
            ->toArray();

        if (empty($logs)) {
            throw new Exception("No more logs to archive");
        }

        $firstLog = $logs[0] ?? [];

        if (empty($firstLog)) {
            throw new Exception("First log entity not found");
        }

        $headers = array_keys($firstLog); // csv header
        // $logIds = array_column($logs, 'id');

        // create directory tmp if it does not exist
        if (!file_exists($directory = storage_path('tmp'))) {
            mkdir($directory, 0777, true);
        }

        // open csv file
        $filename = sprintf('%s-site-access-logs.csv', date('Y-m-d H:i:s'));
        $localFileFullPath = storage_path('tmp') . "/$filename";
        $handle = fopen($localFileFullPath, 'w');

        // put headers once
        fputcsv($handle, $headers);

        // Push each row to a temp csv file
        foreach ($logs as $log) {
            fputcsv($handle, $log);
        }

        if (!file_exists($localFileFullPath)) {
            throw new Exception("Failed to create log file $filename");
        }

        // Upload to archives folder
        $s3FilePath = s3_generate_file_path('site_access_logs', $filename);
        $this->client->put($s3FilePath, file_get_contents($localFileFullPath));

        // delete temp file
        unlink($localFileFullPath);

        // delete do not delete for now
        //SiteAccessLog::query()
        //    ->whereIn('id', $logIds )
        //    ->delete();
    }


}
