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
        $pc = ProductCategory::find($categoryId);

        if (!$pc) {
            return response()->json(["errors" => 'Product category not found'], 404);
        }

        return response()->json(["product_category" => $pc], 200);
    }


    /**
     * Returns all parent categories (filtered by account id)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allParentCategories(Request $request)
    {
        $parent_categories = ProductCategory::getAllParentProductCategories($request->header('x-account-id'));

        return response()->json(['parent_categories' => $parent_categories], 200);
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
            $pc = ProductCategory::findOrFail($request->id);
        } else {
            // edit mode
            $pc = new ProductCategory();
            $pc->account_id = $request->header('x-account-id');
        }

        $pc->name = $request->name;
        $pc->parent_id = $request->parent_id ? $request->parent_id : NULL;
        $pc->is_featured = $request->is_featured;

        if (!$pc->save()) {
            return response()->json(["errors" => "An error occurred while saving entry"], 404);
        }

        return response()->json(['product_category' => $pc], 200);
    }

    public function toggleIsFeatured(Request $request, string $categoryId)
    {
        $pc = ProductCategory::find($categoryId);

        if (!$pc) {
            return response()->json(["errors" => 'Product category not found'], 404);
        }

        $pc->is_featured = $pc->is_featured === 1 ? 0 : 1;

        if (!$pc->save()) {
            return response()->json(["errors" => 'There was a problem saving the product category'], 500);
        }

        return response()->json(["product_category" => $pc], 200);
    }


    /**
     * @param Request $request
     * @param string $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, string $categoryId)
    {
        $pc = ProductCategory::find($categoryId);

        if (!$pc) {
            return response()->json(["errors" => 'Product category not found'], 404);
        }

        if (!$pc->delete()) {
            return response()->json(["errors" => 'There was a problem deleting the product category'], 500);
        }

        $children = ProductCategory::where('parent_id', $pc->id)
            ->update(['parent_id' => NULL]);

        return response()->json([], 200);
    }
}
