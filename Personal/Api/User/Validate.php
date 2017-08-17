<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/1/001
 * Time: 23:37
 */
class Api_User_Validate extends PhalApi_Api{

    private static $Domain = null;
    public function __construct()
    {
        if (self::$Domain == null) {
            self::$Domain = new Domain_User_Validate();
        }
    }

    public function getRules()
    {
        return [
            'ValidateMail'=>[
                'mailToken'     => ['name'=>'mailToken','type'=>'string','require' => true,'desc' => '验证码'],
                'userid'        => ['name'=>'userid','type'=>'int','require' => true,'desc' => '用户id'],
            ],
            'ChagenPasswordSend'=>[
                'email'         => ['name'=>'email','regex' => '/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/','desc' => '邮箱'],
            ],
            'ChagenPasswordReceive'=>[
                'mailToken'     => ['name'=>'mailToken','type'=>'string','require' => true,'desc' => '验证码'],
                'userid'        => ['name'=>'userid','type'=>'int','require' => true,'desc' => '用户id'],
                'password'      => ['name'=>'password','regex' => '/^[0-9A-Za-z]{6,14}$/','require' => true,'desc' => '新的用户密码'],
            ],


        ];
    }

    /**
     * 邮箱验证合法
     * @desc 免鉴权接口
     * @return int code 操作码0：成功，1：链接已失效
     * @return string msg 提示信息
     */
    public function ValidateMail(){
        $rs = ['code' => 0, 'msg' => 'success'];
        $re = self::$Domain->ValidateMail($this->mailToken,$this->userid);

        if(!$re){
            $rs = ['code' => 2, 'msg' => '链接已失效，请重新验证！'];
        }
        return $rs;
    }

    /**
     * 发送修改密码邮件
     * @desc 免鉴权接口
     * @return int code 操作码0：发送成功，1：该邮箱未注册
     * @return string msg 提示信息
     */
    public function ChagenPasswordSend(){
        $rs = ['code' => 0, 'msg' => 'success'];
        $re = self::$Domain->ChagenPasswordSend($this->email);

        if($re==1){
            $rs = ['code' => 1, 'msg' => '该邮箱未注册!'];
        }
        if($re==2){
            $rs = ['code' => 2, 'msg' => '该邮箱未通过认证！'];
        }
        return $rs;
    }

    /**
     * 发送修改密码邮件
     * @desc 免鉴权接口
     * @return int code 操作码0：修改成功，1：无效链接，2：修改密码失败
     * @return string msg 提示信息
     */
    public function ChagenPasswordReceive(){
        $rs = ['code' => 0, 'msg' => '修改成功！'];
        $re = self::$Domain->ChagenPasswordReceive($this->mailToken,$this->userid,$this->password);
        if($re==1){
            $rs = ['code' => 1, 'msg' => '无效链接!'];
        }
        if($re==2){
            $rs = ['code' => 2, 'msg' => '修改密码失败！'];
        }
        return $rs;
    }
}