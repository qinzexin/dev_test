<?php

namespace app\rbac\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    protected $url=['Login/save','Login/index'];
    //初始化方法
    public function _initialize()
    {
        parent::_initialize();
        //允许的源域名
        header("Access-Control-Allow-Origin: *");
        //允许的请求头信息
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        //允许的请求类型
        header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS,PATCH');

    }

}
