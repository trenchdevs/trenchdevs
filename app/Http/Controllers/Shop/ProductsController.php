<?php

namespace App\Http\Controllers\Shop;

use App\Helpers\AmazonS3Helper;
use App\Http\Controllers\Auth\ApiController;
use App\Product;
use App\ProductCategory;
use App\Repositories\ProductsRepository;
use App\Repositories\ShopProductsRepository;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ProductsController extends ApiController
{
    private $productsRepository;
    private $s3;

    /**
     * UserCertificationsController constructor.
     * @param ProductsRepository $productsRepository
     */
    public function __construct(ProductsRepository $productsRepository, AmazonS3Helper $s3)
    {
        $this->productsRepository = $productsRepository;
        $this->s3 = $s3;
    }

    public function showBulkUpload(Request $request)
    {
        $user = $request->user();

        // Temporary
        if (!$user->canManageShop()) {
            die("403");
        }

        return view('shop.bulkupload');
    }

    public function bulkUpload(Request $request)
    {

        /** @var User $user */
        $user = $request->user();

        // Temporary
        if (!$user->canManageShop()) {
            die("403");
        }

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
     * @return JsonResponse
     */
    public function all(Request $request)
    {
        return $this->responseHandler(function () use ($request) {
            return Product::query()->where('owner_user_id', '=', auth()->id())
                ->orderBy('id', 'desc')
                ->paginate(15);
        });
    }

    /**
     * @param Request $request
     * @param string $productId
     * @return JsonResponse
     */
    public function one(Request $request, string $productId)
    {
        return $this->responseHandler(function () use ($productId) {

            $hiddenCols = ['product_category_id', 'account_id'];

            /** @var Product $product */
            if (!$product = Product::query()->find($productId)->makeHidden($hiddenCols)) {
                throw new InvalidArgumentException("Product Not found");
            }

            if (!$product->hasAccess(auth()->user())) {
                throw new InvalidArgumentException("Forbidden");
            }

            return $product;
        });
    }

    /**
     * Upsert product
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function upsert(Request $request)
    {
        $editMode = !!$request->id;

        return $this->responseHandler(function () use ($request, $editMode) {

            $rules = Product::$rules;

            if ($editMode && $request->input('image_url')) {
                // edit mode + image url is set. Do not require image
                unset($rules['image']);
                $rules['image_url'] = 'required';
            }

            $this->validate($request, $rules);

            if ($editMode) {
                $product = Product::query()->findOrFail($request->id); // edit mode

                if (!$product->hasAccess(auth()->user())) {
                    throw new InvalidArgumentException("Forbidden");
                }

            } else {
                $product = new Product();
            }


            $requestData = $request->all();
            $image = $request->file('image');

            if ($image) {
                $requestData['image_url'] = $this->s3->upload($request->image, 'shop/product-images', $image->getClientOriginalName());
            }

            $requestData['owner_user_id'] = auth()->user()->id;

            $product->fill($requestData);
            $product->save();

            return $product;

        }, sprintf('Successfully %s product', $editMode ? "updated" : "added new"));
    }

    /**
     * @param Request $request
     * @param string $categoryId
     * @return JsonResponse
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
