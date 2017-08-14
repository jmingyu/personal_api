<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/1/001
 * Time: 23:50
 */
class Model_Article_Comment extends Common_Model {

    protected function getTableName($id){
        return 'comment';
    }

}