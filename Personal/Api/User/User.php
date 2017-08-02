<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/1/001
 * Time: 23:37
 */
class Api_User_User extends PhalApi_Api{

    private static $Domain = null;
    public function __construct()
    {
        if (self::$Domain == null) {
            self::$Domain = new Domain_User_User();
        }
    }

    public function getRules()
    {
        return [
            'add'=>[
                'username' => ['name'=>'username','type'=>'string','min'=>6,'max'=>32,'require' => true,'desc' => '用户名'],
                'password' => ['name'=>'password','regex' => '/^[0-9A-Za-z]{6,14}$/','require' => true,'desc' => '密码'],
                'nickname' => ['name'=>'nickname','type'=>'string','min'=>6,'max'=>16,'require' => true,'desc' => '昵称'],
            ],
        ];
    }


    /**
     * 用户注册
     * @desc 免鉴权接口
     * @return int code 操作码0：成功，1：失败 ,2:用户名或昵称已存在
     * @return string msg 提示信息
     */
    public function add(){
        $rs = ['code' => 0, 'msg' => 'success'];
        $re = self::$Domain->add($this);

        if($re==2){
            $rs = ['code' => 2, 'msg' => '用户名或昵称已存在'];
        }
        if ($re === false) {
            DI()->logger->debug('User_User.add error', $this);
            $rs['code'] = 1;
            $rs['msg'] = $re;
        }

        return $rs;
    }
}