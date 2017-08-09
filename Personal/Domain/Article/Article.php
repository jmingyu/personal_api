<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/1/001
 * Time: 23:48
 */
class Domain_Article_Article{

    private static $Model = null;
    public function __construct()
    {
        if (!isset(self::$Model)) {
            self::$Model = new Model_Article_Article();
        }
    }

    public function add($data){
        $params = [
            'title' => $data->title,
            'content' => $data->content,
            'cid' => $data->cid,
            'type' => $data->type,
        ];
        $params=DI()->tool->filter_null($params);

        return self::$Model->add($params);
    }



}