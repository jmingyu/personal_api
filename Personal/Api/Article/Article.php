<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/1/001
 * Time: 23:37
 */
class Api_Article_Article extends PhalApi_Api{

    private static $Domain = null;
    public function __construct()
    {
        if (self::$Domain == null) {
            self::$Domain = new Domain_Article_Article();
        }
    }

    public function getRules()
    {
        return [
            'add'=>[
                'token'     => ['name'=>'token','type'=>'string','require' => true,'desc' => '服务器令牌'],
                'userid'     => ['name'=>'userid','type'=>'int','require' => true,'desc' => '用户id'],
                'title'     => ['name'=>'title','type'=>'string','min'=>1,'max'=>255,'require' => true,'desc' => '文章标题'],
                'content'   => ['name'=>'content','type'=>'string','require' => true,'desc' => '文章内容'],
                'cid'       => ['name'=>'cid','type'=>'int','require' => true,'desc' => '类目id'],
                'type'      => ['name'=>'type','type'=>'int','default'=>0,'desc' => '状态 0:草稿,1:发布'],
            ],
//            'login'=>[
//                'username' => ['name'=>'username','type'=>'string','min'=>6,'max'=>32,'require' => true,'desc' => '用户名'],
//                'password' => ['name'=>'password','regex' => '/^[0-9A-Za-z]{6,14}$/','require' => true,'desc' => '密码'],
//                'captchaToken'   => ['name'=>'captchaToken','require' => true,'desc' => '验证码token'],
//                'captcha'   => ['name'=>'captcha','require' => true,'desc' => '验证码'],
//            ],
//            'isLogin'=>[
//                'uid' => ['name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'],
//                'token' => ['name' => 'token', 'require' => true, 'desc' => '登录成功后服务端返回给客户端的令牌'],
//            ],
//            'getCaptcha'=>[
//            ],
        ];
    }


    /**
     * 添加文章
     * @desc 鉴权接口：管理员
     * @return int code 操作码0：成功，1：失败
     * @return string msg 提示信息
     */
    public function add(){
        $rs = ['code' => 0, 'msg' => 'success'];
        return $re = self::$Domain->add($this);

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