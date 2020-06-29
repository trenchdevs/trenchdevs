<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Returns all product categories
     * Sorted by parent_id in descending order
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
//        $product_categories = ProductCategory::where('account_id', account_id)
//            ->orderBy('parent_id', 'desc')
//            ->orderBy('name', 'asc');

        $product_categories = ProductCategory::orderBy('parent_id', 'desc')
            ->orderBy('name', 'asc')
            ->get();

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

        return response()->json([
            'product_categories' => $parentCategories,
        ]);
    }
}
