<?php

namespace app\test11\controller;

use think\Controller;
use think\Request;

class User extends Controller
{
    /**
     * 显示角色列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //角色列表
        $data = model("Role")->select();
        return view("user",['data'=>$data]);
    }
    /**
     * 显示登录单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view("login");
    }

    /**
     * 登录成功的方法
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //接收参数
        $param = $request->param();
        $result = $this->validate(
            $param,
            [
                'user_name|用户名'  => 'require|max:25',
                'user_pwd|密码'   => 'require',
            ]);
        if(true !== $result){
            // 验证失败 输出错误信息
            dump($result);
        }
        $user_name = $param['user_name'];
        $user_pwd = $param['user_pwd'];
        $info = model("User")->where("user_name",$user_name)->find();
        $pwd = model("User")->where("user_pwd",$user_pwd)->find();
        if ($info && $pwd){
            session_start();
            session('user',$info);
            return  $this->redirect('User/index');
        }
    }

    /**
     * 添加角色
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read(Request $request)
    {
        $param = $request->param();
        $result = $this->validate(
            $param,
            [
                'pid|父级'  => 'require',
                'role_name|角色'   => 'require',
            ]);
        if(true !== $result){
            // 验证失败 输出错误信息
            dump($result);
        }
        $data = model("Role")->allowField(true)->save($param);
        if ($data){
            return $this->redirect('User/index');;
        }
    }

    /**
     * 添加用户
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit(Request $request)
    {
        $param = $request->param();
        $result = $this->validate(
            $param,
            [
                'user_name|用户名'  => 'require',
                'user_pwd|密码'   => 'require',
                'user_id|角色'   => 'require',
            ]);
        if(true !== $result){
            // 验证失败 输出错误信息
            dump($result);
        }
        $data = model("User")->allowField(true)->save($param);
        if ($data){
           return  $this->redirect('User/index');
        }
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
