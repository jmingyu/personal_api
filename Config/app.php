<?php
/**
 * 请在下面放置任何您需要的应用配置
 */

return array(

    /**
     * 应用接口层的统一参数
     */
    'apiCommonRules' => array(
        //'sign' => array('name' => 'sign', 'require' => true),
    ),

    /**
     * 接口服务白名单，格式：接口服务类名.接口服务方法名
     *
     * 示例：
     * - *.*            通配，全部接口服务，慎用！
     * - Default.*      Api_Default接口类的全部方法
     * - *.Index        全部接口类的Index方法
     * - Default.Index  指定某个接口服务，即Api_Default::Index()
     */
    'service_whitelist' => [
        'Default.Index',
    ],

//Redis配置项
    'redis' => [
        //Redis缓存配置项
        'servers'  => [
            'host'   => '127.0.0.1',        //Redis服务器地址
            'port'   => '6379',             //Redis端口号
            'prefix' => 'blog_',      //Redis-key前缀
            'auth'   => '123456',    //Redis链接密码
        ],
        // Redis分库对应关系
        'DB'       => [
            'user' => 1,
            //'user'       => 2,
            'code'       => 3,
        ],
        //使用阻塞式读取队列时的等待时间单位/秒
        'blocking' => 5,
    ],

    'auth' => [
        'auth_on' => true, // 认证开关
        'auth_user' => 'user', // 用户信息表
        'auth_group' => 'auth_group', // 组数据表名
//        'auth_group_access' => 'auth_group_access', // 用户-组关系表
        'auth_rule' => 'auth_rule', // 权限规则表
        'auth_not_check_user' => [], //跳过权限检测的用户
        'auth_not_check_api' => [
            'User_User.login','User_User.add','User_User.isLogin','User_User.getCaptcha','Article_Article.Detail','Article_Article.getList',
            ] //跳过权限检测的接口
    ],
);
