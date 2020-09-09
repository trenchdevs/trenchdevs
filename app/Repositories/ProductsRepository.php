<?php

namespace App\Repositories;

use App\Product;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterFactory;
use Illuminate\Support\Facades\Validator;
use TrenchDevs\Csv\CsvReader;
use Exception;


class ProductsRepository
{
    /**
     * @param int $account_id
     * @param string $path
     * @return array
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Reader\Exception\ReaderNotOpenedException
     */
    public static function bulkUpload(int $account_id, string $path): array
    {
        $result = [];
        $rowsToInsert = [];
        $hasSuccess = false;
        $hasError = false;

        $reader = new CsvReader($path);
        $reader->setFirstRowAsHeaders(true);

        foreach ($reader->iterator() as $index => $row) {

            try {

                $row['account_id'] = $account_id;

                $validator = Validator::make($row, Product::$rules);

                if ($validator->fails()) {
                    $errorBag = $validator->errors()->getMessageBag()->all();
                    throw new Exception(implode(' ', $errorBag));
                }

                $productIdentifier = array_intersect_key($row, array_flip(['sku', 'account_id']));

                $productData = array_diff_key($row, $productIdentifier);

                $newProduct = Product::updateOrCreate($productIdentifier, $productData);

                unset($row['account_id']);
                $row['result'] = 'Success';

                array_push($rowsToInsert, $row);

                $hasSuccess = true;

            } catch (Exception $e) {
                unset($row['account_id']);
                $row['result'] = $e->getMessage();

                array_push($rowsToInsert, $row);

                $hasError = true;
            }

        }

        $csvHeaders = $reader->getHeaders();
        array_push($csvHeaders, 'result');

        $result['csvHeaders'] = $csvHeaders;
        $result['csvInserts'] = $rowsToInsert;

//        header("Content-disposition: attachment; filename=test.csv");
//        $fp = fopen('php://output', 'w');
//
//        fputcsv($fp, $csvHeaders);
//        foreach ($rowsToInsert as $rowToInsert) {
//            fputcsv($fp, $rowToInsert);
//        }
//
//        fclose($fp);

        if ($hasSuccess && $hasError) {

            $result['status'] = 'success w/ errors';
            $result['message'] = 'Successfully uploaded  partial product data! Please check CSV file for products with validation errors.';

        } elseif ($hasSuccess && !$hasError) {

            $result['status'] = 'success';
            $result['message'] = 'Successfully uploaded bulk product data!';

        } else {

            $result['status'] = 'errors';
            $result['message'] = 'Bulk product data was not uploaded. Please check CSV file for validation errors.';

        }

        return $result;

    }
}
