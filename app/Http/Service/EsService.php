<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/11
 * Time: 15:05
 */

namespace App\Http\Service;


class EsService
{
    protected $app;

    public function __construct()
    {
       $this->app = app('es');
    }

    /**
     * Notes: 获取索引已添加的字段
     * @param $index
     * @return mixed
     */
    public function getMapping($index)
    {
        return $this->app->indices()->getMapping(['index' => $index]);
    }

    /**
     * Notes: 更新索引字段
     * @param $index
     * @param array $body
     * @return mixed
     */
    public function putMapping($index, array $body = [])
    {
        return $this->app->indices()->putMapping(['index' => $index,'body' => $body]);
    }

    /**
     * Notes: 添加索引
     * @param $index
     * @param array $body
     * @return mixed
     */
    public function create($index,array $body = [])
    {
        return $this->app->indices()->create(['index' => $index,'body' => $body]);
    }

    /**
     * Notes: 判断索引中某条数据是否存在
     * @param $id
     * @param $index
     * @return mixed
     */
    public function exists($id, $index)
    {
        return $this->app->exists(['id' => $id,'index' => $index]);
    }

    /**
     * Notes: 删除索引
     * @param $index
     * @return mixed
     */
    public function delete($index)
    {
        return $this->app->delete(['index' => $index]);
    }


}
