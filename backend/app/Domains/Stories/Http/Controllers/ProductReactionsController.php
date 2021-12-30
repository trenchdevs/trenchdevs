<?php

namespace App\Domains\Stories\Http\Controllers;

use App\Http\Controllers\Auth\ApiController;
use App\Http\Controllers\Controller;
use App\Domains\Products\Models\ProductReaction;
use App\Domains\Products\Models\Product;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ProductReactionsController extends ApiController
{

    public function react()
    {
        return $this->responseHandler(function () {

            $request = request();

            ['product_id' => $productId, 'reaction' => $reaction] = $request->all();

            if (!is_string($reaction) || !in_array($reaction, ProductReaction::WHITELISTED_REACTIONS)) {
                throw new InvalidArgumentException("Reaction invalid");
            }

            if (!$product = Product::query()->find($productId)) {
                throw new InvalidArgumentException("Product not found.");
            }

            $userAgent = $request->header('User-Agent');
            $ip = $request->ip();

            $meta = [
                'ip' => $ip,
                'user_agent' => $userAgent,
            ];

            $userIdentifier = md5("$productId|$ip|$userAgent");
            $productReaction = ProductReaction::query()->where('user_identifier', $userIdentifier)->firstOrNew();

            $productReaction->fill([
                'product_id' => $product->id,
                'reaction' => $reaction,
                'user_identifier' => $userIdentifier,
                'meta_json' => json_encode($meta),
            ]);

            $productReaction->save();

            return $productReaction;
        });
    }
}
