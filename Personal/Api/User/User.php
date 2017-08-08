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
            'login'=>[
                'username' => ['name'=>'username','type'=>'string','min'=>6,'max'=>32,'require' => true,'desc' => '用户名'],
                'password' => ['name'=>'password','regex' => '/^[0-9A-Za-z]{6,14}$/','require' => true,'desc' => '密码'],
                'captchaToken'   => ['name'=>'captchaToken','require' => true,'desc' => '验证码token'],
                'captcha'   => ['name'=>'captcha','require' => true,'desc' => '验证码'],
            ],
            'isLogin'=>[
                'uid' => ['name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'],
                'token' => ['name' => 'token', 'require' => true, 'desc' => '登录成功后服务端返回给客户端的令牌'],
            ],
            'getCaptcha'=>[
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

    /**
     * 用户登陆
     * @desc 免鉴权接口
     * @return int    code      操作码 0：成功，1：帐号或密码错误 ,2:两小时输错密码五次,3:验证码错误
     * @return string msg       提示信息
     * @return int    uid       用户id
     * @return string token     登陆令牌
     */
    public function login(){
        return self::$Domain->login($this);
    }

    /**
     * 检测用户是否登陆
     * @desc 免鉴权接口
     * @return int    code      操作码 0：已登录，1：未登录
     * @return string msg       提示信息
     */
    public function isLogin(){
        $info=self::$Domain->isLogin($this->uid,$this->token);
        if($info==false){
            return ['code' => 1, 'msg' => '用户未登录'];
        }
        return ['code' => 0, 'msg' => 'success'];
    }

    /**
     * 获取验证码图片以及验证码token
     * @desc 免鉴权接口
     * @return int    code      操作码 0：成功，1：失败
     * @return string msg       提示信息
     * @return string img       验证码图片路径
     * @return string captcheToken       验证码token
     */
    public function getCaptcha(){
        $info=self::$Domain->getCaptcha();

        return ['code' => 0, 'msg' => 'success','img'=>$info['path'],'captcheToken'=>$info['token']];
    }




}