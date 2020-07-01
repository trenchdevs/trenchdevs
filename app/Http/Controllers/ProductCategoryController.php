<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Controllers\Auth\ApiController;
use App\ProductCategory;
use App\Utilities\ProductCategoryUtilities;
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
        $accountId = $request->header('x-account-id');

        if (empty($accountId)) {
            return response()->json(["errors" => "Account ID is required"], 404);
        }

        $account = Account::find($accountId);

        if (!$account) {
            return response()->json(["errors" => 'Account not found'], 404);
        }

        $product_categories = ProductCategoryUtilities::getAll($accountId);

        return response()->json([
            "product_categories" => $product_categories
        ], 200);
    }

    public function one(Request $request, string $categoryId)
    {
        $accountId = $request->header('x-account-id');

        if (empty($accountId)) {
            return response()->json(["errors" => "Account ID is required"], 404);
        }

        $account = Account::find($accountId);

        if (!$account) {
            return response()->json(["errors" => 'Account not found'], 404);
        }

        $product_category = ProductCategory::findOrfail($categoryId);

        return response()->json([
            "product_category" => $product_category
        ], 200);
    }


    /**
     * Returns all parent categories (filtered by account id)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allParentCategories(Request $request)
    {
        $accountId = $request->header('x-account-id');

        if (empty($accountId)) {
            return response()->json(["errors" => "Account ID is required"], 404);
        }

        $account = Account::find($accountId);

        if (!$account) {
            return response()->json(["errors" => 'Account not found'], 404);
        }

        $parentCategories = ProductCategory::where('account_id', $accountId)
            ->where('parent_id', NULL)
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            'parent_categories' => $parentCategories
        ], 200);
    }

    /**
     * Upsert product category
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upsert(Request $request)
    {
        $accountId = $request->header('x-account-id');

        if (empty($accountId)) {
            return response()->json(["errors" => "Account ID is required"], 404);
        }

        $account = Account::find($accountId);

        if (!$account) {
            return response()->json(["errors" => 'Account not found'], 404);
        }

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
            $productCategory->account_id = $accountId;
        }

        $productCategory->name = $request->name;
        $productCategory->parent_id = $request->parent_id ? $request->parent_id : NULL;
        $productCategory->is_featured = $request->is_featured;

        if (!$productCategory->save()) {
            return response()->json(["errors" => "An error occurred while saving entry"], 404);
        }

        return response()->json([
            'product_category' => $productCategory
        ], 200);
    }

    public function delete(Request $request, string $categoryId)
    {

        $accountId = $request->header('x-account-id');

        if (empty($accountId)) {
            return response()->json(["errors" => "Account ID is required"], 404);
        }

        $account = Account::find($accountId);

        if (!$account) {
            return response()->json(["errors" => 'Account not found'], 404);
        }

        $productCategory = ProductCategory::find($categoryId);

        if (!$productCategory) {
            return response()->json(["errors" => 'Product category not found'], 404);
        }

        if (!$productCategory->delete()) {
            return response()->json(["errors" => 'There was a problem deleting the product category'], 404);
        }

        return response()->json([], 200);
    }

}
