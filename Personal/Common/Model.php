<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/2/002
 * Time: 0:03
 * 自定义模型通用基类
 */

class Common_Model extends PhalApi_Model_NotORM{

    protected function getTableName($id)
    {

    }

    //新增一条记录
    public function add($data){
        return $this->getORM()->insert($data);
    }

    //根据条件删除一条记录
    public function del(array $condition){
        return $this->getORM()->where($condition)->delete();
    }

    //根据条件修改一条记录
    public function edit(array $contion,$data){
        return $this->getORM()->where($contion)->update($data);
    }

    //根据条件获取第一条数据
    public function getOne(array $condition,$select='*'){
        return $this->getORM()->select($select)->where($condition)->fetchOne();
    }

    //根据条件批量获取数据
    public function getAll(array $condition,$order=null,$limit=null,$offset=0,$select){
        $data=$this->getORM()->select($select)->where($condition);

        if(isset($order)){
            $data=$data->order($order);
        }

        if(isset($limit)){
            $data=$data->limit($limit,$offset);
        }

        return $data->fetchAll();
    }

    //根据条件获取结果数量
    public function count(array $condition){
        return $this->getORM()->where($condition)->count();
    }

    //根据条件获取结果是否存在
    public function isExist(array $condition){
        $count=$this->getORM()->where($condition)->count();
        return $count>0?true:false;
    }
}