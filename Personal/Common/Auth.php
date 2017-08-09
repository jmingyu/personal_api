<?php

class Common_Auth implements PhalApi_Filter
{
    protected $signName;

    public function __construct($signName = 'sign')
    {
        $this->signName = $signName;
    }

    public function check()
    {
        $api = DI()->request->get('service', 'Default.Index'); //获取当前访问的接口

        //判断是不是免检接口
        if (!in_array($api, (array)DI()->config->get('app.auth.auth_not_check_api'))) {

            $userId = DI()->request->get('userid', 0);//获取用户id参数

            //登陆检测
            DI()->userLite->check(true);

            $r = DI()->authLite->check($api, $userId);
            if (!$r) {
                //抛出异常
                DI()->logger->debug('Wrong Auth', array('api' => $api, 'userId' => $userId));
                throw new PhalApi_Exception_BadRequest(T('wrong auth'), 1);
            }
        }

//        if (!in_array($api, (array)DI()->config->get('app.auth.auth_not_sign_api'))) {
//            $allParams = DI()->request->getAll();
//            if (empty($allParams)) {
//                return;
//            }
//
//            $sign = isset($allParams[$this->signName]) ? $allParams[$this->signName] : '';
//            unset($allParams[$this->signName]);
//
//            $expectSign = $this->encryptAppKey($allParams);
//
//            if ($expectSign != $sign) {
//                DI()->logger->debug('Wrong Sign ' . $api, array('needSign' => $expectSign));
//                throw new PhalApi_Exception_BadRequest(T('wrong sign'), 6);
//            }
//        }
    }

    protected function encryptAppKey($params)
    {
        ksort($params);

        $paramsStrExceptSign = '';
        foreach ($params as $val) {
            $paramsStrExceptSign .= $val;
        }

        return md5($paramsStrExceptSign);
    }
}