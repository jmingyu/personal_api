<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/8/008
 * Time: 17:18
 * 工具类
 */
class Common_Tools{

    /**
     * 根据用户信息及当前时间生成令牌
     * @param $uid
     * @param $password
     * @return string
     */
    public function createToken($uid,$password){
        return md5($uid.$password.time().rand(1000,9999));
    }
}