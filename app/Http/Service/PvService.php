<?php


namespace App\Http\Service;


use App\Models\Pv;

class PvService
{
//    protected  $pv;
//
//    public function __construct()
//    {
//        $this->pv = new Pv();
//    }

    public function getList()
    {
        return Pv::query()->get();
    }
}
