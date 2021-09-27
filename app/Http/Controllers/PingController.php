<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/7/20
 * Time: 14:43
 */

namespace App\Http\Controllers;


use App\Http\Service\EsService;
use App\Jobs\Queue;
use App\Models\GoodsProduct;
use App\Models\Member;
use Illuminate\Database\Eloquent\Model;

class PingController extends Controller
{

    public function index(EsService $esService)
    {
//        $arr = ['member_id' => 1];
//        dd(Queue::dispatch($arr));

//        return response()->json([
//            'data' => GoodsProduct::query()->select( [
//                'id',
//                'name',
//                'product_category_id',
//                'product_category_name',
//                'pic',
//                'price',
//                'delete_status',
//                'publish_status'
//            ])->get()
//        ],200);
//
        $app = app('es');
//        dd($esService->create('cs',[
//            'mappings' => [
//                'properties' => [
//                    'type' => [
//                        'type' => 'text'
//                    ]
//                ]
//            ]
//        ]));
        dd(GoodsProduct::query()->get()->toESArray());
//        dd($app->indices()->getMapping(['index' => 'cs']));
////        $data = $app->indices()->delete(['index' => 'products']);
//
//        dd($app->indices()->create(['index' => 'ip','body' => [
////            'settings' => [
//                'mappings' => [
//                    'properties' => [
//                        'title' => [
//                            'type' => 'keyword'
//                        ]
//                    ]
//                ]
////            ],
//        ]]));

        $list = app('es')->search([
            'index' => 'goods_product',
            'body' => [
//                'from' => 0,
//                'size' => 5,
                'query' => [
                    'bool' => [
                        'filter' => [
//                            ['term' => ['name' => '土豆']]
                        ],
                        'must' => [
                            [
                                'multi_match' => [
                                    'query'  => '男女通用',
                                    'fields' => [
                                        'name',
                                    ],
                                ],
                            ],
                        ],
                    ]
                ],
                'sort' => [
                    'id' => 'desc'
                ]
            ]
        ]);

        return response()->json([
            'data' => $list
        ],200);
    }


}


