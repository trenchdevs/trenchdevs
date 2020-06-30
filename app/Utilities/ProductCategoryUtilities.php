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
        $product_categories = ProductCategory::where('account_id', $accountId)
            ->orderBy('parent_id', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        if (count($product_categories)) {

            $parentCategories = [];

            foreach ($product_categories as $row) {
                if (!$row->parent_id) {
                    // is a parent category
                    $parentCategories[$row->id] = $row;
                } else {
                    // is a child
                    if ($parentCategories[$row->parent_id] && $parentCategories[$row->parent_id]['children']) {
                        // children array already exists
                        array_push($parentCategories[$row->parent_id]['children'], $row);
                    } else {
                        // children array does not exist
                        $parentCategories[$row->parent_id]['children'] = [$row];
                    }
                }
            }

            return $parentCategories;
        }

        return $product_categories;
    }
}
