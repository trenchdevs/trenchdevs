<?php


namespace App\Utilities;


use App\ProductCategory;

class ProductCategoryUtilities
{
    /**
     * Returns all product categories
     * Sorted by parent_id in descending order
     *
     * @return array
     */
    public static function getAll(string $accountId)
    {
        $productCategories = ProductCategory::where('account_id', $accountId)
            ->orderBy('parent_id', 'asc')
            ->orderBy('name', 'desc')
            ->get();

        if (!$productCategories->isEmpty()) {

            $parentCategories = [];

            foreach ($productCategories as $row) {

                if (is_null($row->parent_id)) {
                    // is a parent category
                    $parentCategories[$row->id] = $row;
                } else {
                    // is a child
                    if (!is_null($parentCategories[$row->parent_id]) && $parentCategories[$row->parent_id]['children']) {
                        // children array already exists
                        $parentCategories[$row->parent_id]['children'] =
                            array_merge($parentCategories[$row->parent_id]['children'], [$row]);
                    } else {
                        // children array does not exist
                        $parentCategories[$row->parent_id]['children'] = array($row);
                    }
                }
            }

            return array_values($parentCategories);
        }

        return $productCategories;
    }
}
