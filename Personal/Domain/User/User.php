<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/1/001
 * Time: 23:48
 */
class Domain_User_User{
    const MAX_ERROR = 5;

    private static $Model = null;
    public function __construct()
    {
        if (!isset(self::$Model)) {
            self::$Model = new Model_User_User();
        }
    }

    public function add($data){
        $params = [
            'username' => $data->username,
            'nickname' => $data->nickname,
            'password' => MD5($data->password),
            'email'    => $data->email
        ];

        if(self::$Model->getOne([' username = ? OR nickname = ? OR  email = ?'=>[$data->username,$data->nickname,$data->email]])){
            return 2;
        }

        $id=self::$Model->addUser($params);
        if(!$id){
            return false;
        }
        $mailToken=MD5(rand(1000000,9999999).$id.time());
        $data1=[
            'time'=>date('Y-m-d H:i:s'),
            'date'=>date('Y年m月d日'),
            'link'=>DI()->config->get('app.domain').'mailvaildate.html?mailToken='.$mailToken.'&uid='.$id,
        ];
        DI()->cache->set('ValidateMail_' . $id, $mailToken, 3600);
        DI()->mail->send($data->email,0,$data1);
        return 0;
    }

    public function login($data){
        //这里判断验证码错误
        $captchaCache=DI()->cache->get('captcha_' . $data->captchaToken);

        if(!isset($captchaCache)||$captchaCache!=$data->captcha){
            return ['code' => 3, 'info' => [], 'msg' => '验证码错误，请重试！'];
        }

        $info=self::$Model->getOne(['username'=>$data->username]);

        $password=MD5($data->password);

        if($info==false||$info['password']!=$password){//帐号或密码错误

            $cache=DI()->cache->get('loginError_' . $info['id']);

            if($info['password']!=$password){

                if(isset($cache)){
                    if($cache['hits']<self::MAX_ERROR){
                        $cache['hits']++;
                        DI()->cache->set('loginError_' . $info['id'], $cache, $cache['end'] - time());
                        return ['code' => 1, 'info' => [], 'msg' => '密码有误，您还有' . (self::MAX_ERROR - 1) . '次尝试机会'];
                    }
                    return ['code' => 2, 'info' => [], 'msg' => '您尝试的次数已经超过限制，请过一会再尝试吧'];
                }
                $cache = ['hits' => 1, 'end' => strtotime('+2 hour')];
                DI()->cache->set('loginError_' . $info['id'], $cache, 7200);
                return ['code' => 1, 'info' => [], 'msg' => '密码有误，您还有' . (self::MAX_ERROR - 1) . '次尝试机会'];
            }

            if ($cache['hits'] >= self::MAX_ERROR) {
                return ['code' => 2, 'info' => [], 'msg' => '您尝试的次数已经超过限制，请过一会再尝试吧'];
            }
        }
        DI()->cache->delete('captcha_' . $data->captchaToken);//登陆成功删除前面的token

        $token=DI()->tool->createToken($info['id'],$info['password']);
        DI()->cache->set('user_' . $info['id'], $token, 86400);
        return ['code' => 0, 'msg' => 'success','id'=>$info['id'],'token'=>$token];

    }

    public function isLogin($uid,$token){
        $info = self::$Model->getCacheByUser($uid);
        if (isset($info) && $info == $token) {
            DI()->cache->set('user_' . $uid, $token, 86400);//刷新token时间
            return true;
        } else {
            return false;
        }
    }

    public function getCaptcha(){
        $info=DI()->captcha->doimg();//生成验证码

        $token=md5($info['path'].rand(1,99999).$info['code']);//生成一个唯一的token

        DI()->cache->set('captcha_' . $token, $info['code'], 900);//生命周期15分钟

        return ['path'=>$info['path'],'token'=>$token];
    }

    public function getUserInfo($uid){
        $con=['id'=>$uid];
        $select='id,nickname,avatar,isDel,emailValidate,email';
        $data=self::$Model->getOne($con,$select);
        if($data==1){
            return false;
        }
        unset($data['isDel']);
        return $data;
    }

    public function checkParam($data){
        if ($data->username){
            return self::$Model->isExist(['username'=>$data->username]);
        }
        if ($data->nickname){
            return self::$Model->isExist(['nickname'=>$data->nickname]);
        }
        if ($data->email){
            return self::$Model->isExist(['email'=>$data->email]);
        }
        return false;
    }

    public function chagePassword($data){
        $info=self::$Model->getOne(['id'=>$data->UserID]);
        if(MD5($data->old)==$info['password']){
            return self::$Model->edit(['id'=>$data->UserID],['password'=>MD5($data->new)]);
        }
        return false;
    }


}