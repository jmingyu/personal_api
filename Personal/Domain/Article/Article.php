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
            'title'     => $data->title,
            'content'   => $data->content,
            'cid'       => $data->cid,
            'type'      => $data->type,
            'isHot'     => $data->isHot,
            'isComment' => $data->isComment,
        ];
        $params=DI()->tool->filter_null($params);
        $info=self::$Model->add($params);
        if($info){
            return $info['id'];
        }
        return false;
    }

    public function Edit($data){
        $params = [
            'title'     => $data->title,
            'content'   => $data->content,
            'cid'       => $data->cid,
            'type'      => $data->type,
            'isHot'     => $data->isHot,
            'isDel'     => $data->isDel,
            'isComment' => $data->isComment,
        ];
        $params=DI()->tool->filter_null($params);
        $con=['id'=>$data->id];
        $info=self::$Model->edit($con,$params);
        if($info){
            return true;
        }
        return false;
    }

    public function Del($data){
        $params = [
            'isDel' => 1,
        ];
        $con=['id'=>$data->id];
        $info=self::$Model->edit($con,$params);
        if($info){
            return true;
        }
        return false;
    }

    public function Detail($data){
        $con=['id'=>$data->id];
        $info=self::$Model->getOne($con);
        if($info){
            return $info;
        }
        return false;
    }

    public function getList($data){
        $con=[
            'isDel' =>  0,
            'type'  =>  1,
        ];
        if(isset($data->cid)){
            $con['cid']=$data->cid;
        }
        $offset=$data->limit*($data->page-1);
        if($data->hot==1){
            $order='isHot DESC,insertTime DESC';
        }else{
            $order='insertTime DESC';
        }
        $info=self::$Model->getAll($con,$order,$data->limit,$offset,'*');
        if($info){
            return $info;
        }
        return false;
    }

    public function getListAdmin($data){
        $con=[
            'id > ?' => 0,
        ];
        if(isset($data->cid)){
            $con['cid']=$data->cid;
        }
        if($data->type!=2){
            $con['type']=$data->type;
        }
        if($data->isDel!=2){
            $con['isDel']=$data->isDel;
        }
        $offset=$data->limit*($data->page-1);
        if($data->hot==1){
            $order='isHot DESC,insertTime DESC';
        }else{
            $order='insertTime DESC';
        }
        $info=self::$Model->getAll($con,$order,$data->limit,$offset,'*');
        if($info){
            return $info;
        }
        return false;
    }



}