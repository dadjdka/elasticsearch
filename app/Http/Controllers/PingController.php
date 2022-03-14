<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/7/20
 * Time: 14:43
 */

namespace App\Http\Controllers;


use App\Http\Service\EsService;
use App\Http\Service\PvService;
use App\Jobs\Queue;
use App\Models\GoodsProduct;
use App\Models\Member;
use App\Models\Pv;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class PingController extends Controller
{



    public function index(EsService $esService)
    {

        DB::beginTransaction();

        sleep(2);
//        $pv = DB::table('pv')->where('name','index')->sharedLock()->get();
        $pv = DB::table('pv')->where('name','index')->lockForUpdate()->update(['value' => 28]);
        DB::commit();

        return $pv;
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


