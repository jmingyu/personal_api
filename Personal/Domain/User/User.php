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
            'password' => MD5($data->password)
        ];

        if(self::$Model->getOne([' username = ? OR nickname = ? '=>[$data->username,$data->nickname]])){
            return 2;
        }
        return self::$Model->add($params);
    }

    public function login($data){
        //这里判断验证码错误
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
        return ['code' => 0, 'msg' => 'success','uid'=>$info['id']];//这里还要返回token和用户id,建一个工具类返回token

    }


}