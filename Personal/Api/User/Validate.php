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
}