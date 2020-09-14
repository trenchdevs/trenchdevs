<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Auth\ApiController;
use App\Product;
use App\ProductCategory;
use App\Repositories\ProductsRepository;
use App\Repositories\ShopProductsRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends ApiController
{
    private $productsRepository;

    /**
     * UserCertificationsController constructor.
     * @param ProductsRepository $productsRepository
     */
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function showBulkUpload(Request $request)
    {
        return view('shop.bulkupload');
    }

    public function bulkUpload(Request $request)
    {

        /** @var User $user */
        $user = $request->user();

        if (!$request->hasFile('product_data')) {
            return back()->with('error', 'Product CSV file is required');
        }

        $path = $request->file('product_data')->getRealPath();

        if (!file_exists($path)) {
            return back()->with('error', 'Product CSV file is nonexistent');
        }

        $result = $this->productsRepository->bulkUpload($user->account_id, $path);

        header("Content-disposition: attachment; filename=RESULTS.csv");
        $fp = fopen('php://output', 'w');

        fputcsv($fp, $result['csvHeaders']);
        foreach ($result['csvInserts'] as $rowToInsert) {
            fputcsv($fp, $rowToInsert);
        }

        fclose($fp);
    }

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

        $validator = Validator::make($request->all(), Product::$rules);

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
