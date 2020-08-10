<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\ApiController;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends ApiController
{
    /**
     * Returns all product categories (filtered by account id)
     * Sorted by parent_id in descending order
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        $product_categories = ProductCategory::getAll($request->header('x-account-id'));

        return response()->json([
            "product_categories" => $product_categories
        ], 200);
    }


    /**
     * @param Request $request
     * @param string $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function one(Request $request, string $categoryId)
    {
        $product_category = ProductCategory::find($categoryId);

        if (!$product_category) {
            return response()->json(["errors" => 'Product category not found'], 404);
        }

        return response()->json(["product_category" => $product_category], 200);
    }


    /**
     * Returns all parent categories (filtered by account id)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allParentCategories(Request $request)
    {
        $parentCategories = ProductCategory::getAllParentProductCategories($request->header('x-account-id'));

        return response()->json(['parent_categories' => $parentCategories], 200);
    }

    /**
     * Upsert product category
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upsert(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'is_featured' => 'required|max:1000'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorBag = $validator->errors()->getMessageBag()->all();
            return response()->json(["errors" => implode(' ', $errorBag)], 404);
        }

        // see if provided parent id exists (ex. 0, 1 .. but not null)
        if (!empty($request->parent_id) && !is_null($request->parent_id)) {
            $parentCategory = ProductCategory::find($request->parent_id);

            if (!$parentCategory) {
                return response()->json(["errors" => "Parent category not found"], 404);
            }
        }

        if (!empty($request->id)) {
            $productCategory = ProductCategory::findOrFail($request->id);
        } else {
            // edit mode
            $productCategory = new ProductCategory();
            $productCategory->account_id = $request->header('x-account-id');
        }

        $productCategory->name = $request->name;
        $productCategory->parent_id = $request->parent_id ? $request->parent_id : NULL;
        $productCategory->is_featured = $request->is_featured;

        if (!$productCategory->save()) {
            return response()->json(["errors" => "An error occurred while saving entry"], 404);
        }

        return response()->json(['product_category' => $productCategory], 200);
    }

    public function toggleIsFeatured(Request $request, string $categoryId)
    {
        $productCategory = ProductCategory::find($categoryId);

        if (!$productCategory) {
            return response()->json(["errors" => 'Product category not found'], 404);
        }

        $productCategory->is_featured = !$productCategory->is_featured;

        if (!$productCategory->save()) {
            return response()->json(["errors" => 'There was a problem saving the product category'], 500);
        }

        return response()->json(["product_category" => $productCategory], 200);
    }


    /**
     * @param Request $request
     * @param string $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, string $categoryId)
    {
        $productCategory = ProductCategory::find($categoryId);

        if (!$productCategory) {
            return response()->json(["errors" => 'Product category not found'], 404);
        }

        if (!$productCategory->delete()) {
            return response()->json(["errors" => 'There was a problem deleting the product category'], 500);
        }

        $children = ProductCategory::where('parent_id', $productCategory->id)
            ->update(['parent_id' => NULL]);

        return response()->json([], 200);
    }
}
