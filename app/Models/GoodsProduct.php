<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/10
 * Time: 14:34
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class GoodsProduct extends Model
{
    protected $table = 'goods_product';

    public function toESArray()
    {
        // 只取出需要的字段
        return Arr::only($this->toArray(), [
            'id',
            'name',
            'product_category_id',
            'product_category_name',
            'pic',
            'price',
            'delete_status',
            'publish_status'
        ]);
    }

}
