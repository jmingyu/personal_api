<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/1/001
 * Time: 23:48
 */
class Domain_User_User{

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
        return self::$Model->add($params);
    }


}