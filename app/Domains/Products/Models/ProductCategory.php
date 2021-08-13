<?php

namespace App\Domains\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductCategory extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'is_featured', 'is_archived', 'parent_id', 'account_id'
    ];

    /**
     * @param string $accountId
     * @return array
     */
    public static function getAll(string $accountId)
    {
        $productCategories = ProductCategory::where('account_id', $accountId)
            ->orderBy('parent_id', 'asc')
            ->orderBy('name', 'desc')
            ->get();

        if (!$productCategories->isEmpty()) {

            $parentCategories = [];

            foreach ($productCategories as $row) {

                if (is_null($row->parent_id)) {
                    // is a parent category
                    $parentCategories[$row->id] = $row;
                } else {
                    // is a child
                    if (!is_null($parentCategories[$row->parent_id]) && $parentCategories[$row->parent_id]['children']) {
                        // children array already exists
                        $parentCategories[$row->parent_id]['children'] =
                            array_merge($parentCategories[$row->parent_id]['children'], [$row]);
                    } else {
                        // children array does not exist
                        $parentCategories[$row->parent_id]['children'] = array($row);
                    }
                }
            }

            usort($parentCategories, function ($a, $b) {
                return strcmp($a->name, $b->name);
            });

            return array_values($parentCategories);
        }

        return $productCategories;
    }

    /**
     * @param string $accountId
     * @return mixed
     */
    public static function getAllParentProductCategories(string $accountId)
    {
        return ProductCategory::where('account_id', $accountId)
            ->where('parent_id', NULL)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * @param $productCategoryId
     * @return int
     */
    public static function deleteProductCategory($productCategoryId)
    {
        $pc = ProductCategory::find($productCategoryId);

        DB::beginTransaction();

        try {
            ProductCategory::where('parent_id', $productCategoryId)
                ->update(['parent_id' => NULL]);
            // TODO: Sean (Cascade to related products)
            $pc->delete();

            DB::commit();

            return 1;
        } catch (Exception $ex) {
            DB::rollback();

            return 0;
        }
    }

}
