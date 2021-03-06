<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/1/001
 * Time: 23:50
 */
class Model_User_User extends Common_Model {

    protected function getTableName($id){
        return 'user';
    }

    public function getCacheByUser($uid){
        return DI()->cache->get("user_{$uid}");
    }

    public function addUser($data){
        $add=$this->getORM();
        $add->insert($data);
        return $add->insert_id();
    }

}