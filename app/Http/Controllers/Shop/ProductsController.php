<?php

namespace App\Http\Controllers\Shop;

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

    public function showBulkUpload(Request $request)
    {
        return view('shop.bulkupload');
    }

    public function bulkUpload(Request $request)
    {
        // NOTE: Arrangement of clomuns should be as follows:
        // SKU, NAME, STOCK, MSRP

        if ($request->hasFile('student_data')) {

            $path = $request->file('student_data')->getRealPath();

            $result = StudentUploadUtilities::bulkUpload($path);

            return redirect('/')->with('success', 'Successfully upload bulk student data!');

        } else {

            return redirect('/')->with('error', 'Error.');

        }
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
            'name' => 'required|string|max:255',
            'stock' => 'required|integer',
            'sku' => 'required|string|max:255',
            'msrp' => 'required|numeric',
            'product_category_id' => 'nullable|integer',
            'description' => 'nullable|string|max:255',
            'product_cost' => 'nullable|numeric',
            'shipping_cost' => 'nullable|numeric',
            'handling_cost' => 'nullable|numeric',
            'final_cost' => 'nullable|numeric',
            'markup_percentage' => 'nullable|numeric',
            'attributes' => 'nullable|json',
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
