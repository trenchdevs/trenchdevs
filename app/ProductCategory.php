<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public static function getAllParentProductCategories(string $accountId)
    {
        return ProductCategory::where('account_id', $accountId)
            ->where('parent_id', NULL)
            ->orderBy('name', 'asc')
            ->get();
    }
}
