<?php

namespace App\Repositories;

use App\Product;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductsRepository
{
    /**
     * @param string $path
     * @return string
     * @throws Exception
     */
    public static function bulkUpload(int $account_id, string $path): string
    {

        try {

            DB::beginTransaction();

            $reader = ReaderEntityFactory::createReaderFromFile($path . '.csv');

            $reader->open($path);

            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $index => $row) {
                    if ($index != 1) {
                        $cells = $row->getCells();

                        $newProduct = Product::updateOrCreate([
                            'sku' => trim($cells[0]),
                        ], [
                            'account_id' => (int) $account_id,
                            'name' => trim($cells[1]),
                            'stock' => (int) trim($cells[2]),
                            'msrp' => (float) number_format((float) trim($cells[3]), 4),

                        ]);
                    }
                }
            }

            DB::commit();

            $reader->close();

            return 1;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }
}
