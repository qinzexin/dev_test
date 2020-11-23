<?php

namespace app\test11\controller;

use app\test11\model\User;
use think\Controller;
use think\Request;

class Login extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 登录页面
     *
     * @return \think\Response
     */
    public function create()
    {
        return view("login");
    }

    /**
     * 登录方法
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
        $info = User::where("user_name",$user_name)->find();
        $pwd = User::where("user_pwd",$user_pwd)->find();
        if ($info && $pwd){
            session_start();
            session('user',$info);
            return  $this->redirect('Login/read');
        }
    }

    /**
     * 权限列表
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read()
    {
        //取出sess里面的数据并赋值
        $user_id = session('user');
        $id = $user_id['user_id'];
//        列表查询
        $res = db('user')
            ->field("power.*")
            ->join('u_r','user.user_id=u_r.user_id')
            ->join('role','role.role_id=u_r.role_id')
            ->join('r_p','role.role_id=r_p.role_id')
            ->join('power','r_p.power_id=power.power_id')
            ->where('user.user_id',$id)
            ->select();
       $res = get_cate_list($res,0,1);
       return view("user",['data'=>$res]);

    }

    /**
     * 权限新增.
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
                'pid|父级'  => 'require',
                'power_name|权限名'   => 'require',
            ]);
        if(true !== $result){
            // 验证失败 输出错误信息
            dump($result);
        }
        $data = model("Power")->allowField(true)->save($param);
        if ($data){
            return "添加成功";
        }
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function user()
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
