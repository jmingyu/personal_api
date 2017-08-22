<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/1/001
 * Time: 23:37
 */
class Api_Article_Article extends PhalApi_Api{

    public function getRules()
    {
        return [
            'UploadImg'=>[
                'token'     => ['name'=>'token','type'=>'string','require' => true,'desc' => '服务器令牌'],
                'UserID'    => ['name'=>'userid','type'=>'int','require' => true,'desc' => '用户id'],
                'file' => array(
                    'name' => 'file',
                    'type' => 'file',
                    'min'  => 0,
                    'max'  => 1024 * 1024 * 2,
                    'range'=> array('image/gif', 'image/jpg', 'image/jpeg', 'image/png'),
                    'ext'  => array('gif', 'jpg', 'jpeg', 'png'),
                    'require' => true
                ),
            ],


        ];
    }


    /**
     * 上传图片接口
     * @desc 鉴权接口：普通用户
     * @return int       code 操作码0：成功，1：失败
     * @return string    msg  提示信息
     * @return int       id   新增文章id
     */
    public function UploadImg(){
        $rs = ['code' => 0, 'msg' => 'success'];

    }








}