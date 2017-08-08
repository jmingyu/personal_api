<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/8/008
 * Time: 17:00
 */
class User_Lite{

    /**
     * 登录检测
     * @param boolean $isExitIfNotLogin 是否抛出异常以便让接口错误返回
     * @return boolean
     * @throws PhalApi_Exception_BadRequest
     */
    public function check($isExitIfNotLogin=false){
        $api = DI()->request->get('service', 'Default.Index'); //获取当前访问的接口
        $userId = DI()->request->get('userid');
        $token = DI()->request->get('token');

        //是否缺少必要参数
        if (empty($userId) || !isset($token)) {
            DI()->logger->debug('needLogin', array('api' => $api, 'userId' => $userId, 'token' => $token));

            if ($isExitIfNotLogin) {
                throw new PhalApi_Exception_BadRequest(T('需要登陆'), 1);
            }
            return false;
        }

        $domain = new Domain_User_User();
        if (!$domain->isLogin($userId, $token)) {
            DI()->logger->debug('needLogin', array('api' => $api, 'userId' => $userId, 'token' => $token));
            throw new PhalApi_Exception_BadRequest(T('需要登陆'), 1);
        }

        return true;
    }
}