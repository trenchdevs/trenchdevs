<?php

namespace App\Http\Controllers;

use App\Account;
use App\ProductCategory;
use App\Utilities\ProductCategoryUtilities;
use Illuminate\Http\Request;

use ErrorException;
use Exception;
use InvalidArgumentException;

class ProductCategoryController extends Controller
{
    /**
     * Returns all product categories
     * Sorted by parent_id in descending order
     *
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
            'product_categories' => $product_categories
        ], 200);
    }
}
