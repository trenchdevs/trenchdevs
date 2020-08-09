<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\ApiController;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends ApiController
{
    /**
     * Returns all products according to corresponding account
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        $products = Product::where('account_id', $request->header('x-account-id'))
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            "products" => $products
        ], 200);
    }

    /**
     * @param Request $request
     * @param string $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function one(Request $request, string $productId)
    {
        $product = Product::findOrfail($productId);

        return response()->json(["product" => $product], 200);
    }

    /**
     * Upsert product
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upsert(Request $request)
    {
        $rules = [
            'product_category_id' => 'required|integer',
            'name' => 'required|string|max:250',
            'description' => 'required|string|max:250',
            'stock' => 'required|integer',
            'product_cost' => 'required|numeric',
            'is_on_sale' => 'boolean',
            'shipping_cost' => 'numeric',
            'handling_cost' => 'numeric',
            'sale_product_cost' => 'numeric',
            'final_cost' => 'numeric',
            'attributes' => 'json',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorBag = $validator->errors()->getMessageBag()->all();
            return response()->json(["errors" => implode(' ', $errorBag)], 404);
        }

        $product_category = ProductCategory::find($request->product_category_id);

        if (!$product_category) {
            return response()->json(["errors" => 'Product category not found'], 404);
        }

        if (!empty($request->id)) {
            // edit mode
            $product = Product::findOrFail($request->id);
        } else {
            $product = new Product();
            $product->account_id = $request->header('x-account-id');
        }

        $product->fill($request->all());

        if (!$product->save()) {
            return response()->json(["errors" => "An error occurred while saving entry"], 404);
        }

        return response()->json(['product' => $product], 200);
    }

    /**
     * @param Request $request
     * @param string $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, string $categoryId)
    {
        $product = Product::find($categoryId);

        if (!$product) {
            return response()->json(["errors" => 'Product category not found'], 404);
        }

        if (!$product->delete()) {
            return response()->json(["errors" => 'There was a problem deleting the product category'], 500);
        }

        return response()->json([], 200);
    }
}
