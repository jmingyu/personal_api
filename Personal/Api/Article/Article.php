<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/1/001
 * Time: 23:37
 */
class Api_Article_Article extends PhalApi_Api{

    private static $Domain = null;
    public function __construct()
    {
        if (self::$Domain == null) {
            self::$Domain = new Domain_Article_Article();
        }
    }

    public function getRules()
    {
        return [
            'Add'=>[
                'token'     => ['name'=>'token','type'=>'string','require' => true,'desc' => '服务器令牌'],
                'UserID'    => ['name'=>'userid','type'=>'int','require' => true,'desc' => '用户id'],
                'title'     => ['name'=>'title','type'=>'string','min'=>1,'max'=>255,'require' => true,'desc' => '文章标题'],
                'content'   => ['name'=>'content','type'=>'string','require' => true,'desc' => '文章内容'],
                'cid'       => ['name'=>'cid','type'=>'int','require' => true,'desc' => '类目id'],
                'type'      => ['name'=>'type','type' => 'enum' , 'range' => array(0,1),'default'=>0,'desc' => '状态 0:草稿,1:发布'],
                'isHot'     => ['name'=>'isHot','type' => 'enum' , 'range' => array(0,1),'default'=>0,'desc' => '是否置顶 0:否 1:是'],
                'isComment' => ['name'=>'isComment','type' => 'enum' , 'range' => array(0,1),'default'=>1,'desc' => '是否能评论 0:否 1:是'],
            ],

            'Edit'=>[
                'token'     => ['name'=>'token','type'=>'string','require' => true,'desc' => '服务器令牌'],
                'UserID'    => ['name'=>'userid','type'=>'int','require' => true,'desc' => '用户id'],
                'id'        => ['name'=>'id','type'=>'int','require' => true,'desc' => '文章id'],
                'title'     => ['name'=>'title','type'=>'string','min'=>1,'max'=>255,'desc' => '文章标题'],
                'content'   => ['name'=>'content','type'=>'string','desc' => '文章内容'],
                'cid'       => ['name'=>'cid','type'=>'int','desc' => '类目id'],
                'type'      => ['name'=>'type','type' => 'enum' , 'range' => array(0,1),'desc' => '状态 0:草稿,1:发布'],
                'isHot'     => ['name'=>'isHot','type' => 'enum' , 'range' => array(0,1),'desc' => '是否置顶 0:否 1:是'],
                'isDel'     => ['name'=>'isDel','type' => 'enum' , 'range' => array(0,1),'desc' => '是否删除 0:否,1:是'],
                'isComment' => ['name'=>'isComment','type' => 'enum' , 'range' => array(0,1),'default'=>1,'desc' => '是否能评论 0:否 1:是'],
            ],
            'Del'=>[
                'token'     => ['name'=>'token','type'=>'string','require' => true,'desc' => '服务器令牌'],
                'UserID'    => ['name'=>'userid','type'=>'int','require' => true,'desc' => '用户id'],
                'id'        => ['name'=>'id','type'=>'int','require' => true,'desc' => '文章id'],
            ],
            'Detail'=>[
                'id'        => ['name'=>'id','type'=>'int','require' => true,'desc' => '文章id'],
            ],
            'getList'=>[
                'limit'     => ['name'=>'limit','type'=>'int','require' => true,'desc' => '显示数量'],
                'page'      => ['name'=>'page','type'=>'int','require' => true,'desc' => '页数'],
                'cid'       => ['name'=>'cid','type'=>'int','desc' => '类目'],
                'hot'       => ['name'=>'hot','type' => 'enum' , 'range' => array(0,1),'require' => true,'desc' => '是否显示置顶 0:否 1:是'],
            ],
            'getListAdmin'=>[
                'token'     => ['name'=>'token','type'=>'string','require' => true,'desc' => '服务器令牌'],
                'UserID'    => ['name'=>'userid','type'=>'int','require' => true,'desc' => '用户id'],
                'limit'     => ['name'=>'limit','type'=>'int','require' => true,'desc' => '显示数量'],
                'page'      => ['name'=>'page','type'=>'int','require' => true,'desc' => '页数'],
                'cid'       => ['name'=>'cid','type'=>'int','desc' => '类目'],
                'hot'       => ['name'=>'hot','type' => 'enum' , 'range' => array(0,1),'require' => true,'desc' => '是否显示置顶 0:否 1:是'],
                'type'      => ['name'=>'type','type' => 'enum' , 'range' => array(0,1,2),'require' => true,'desc' => '0:草稿,1:发布,2:全部'],
                'isDel'     => ['name'=>'isDel','type' => 'enum' , 'range' => array(0,1,2),'require' => true,'desc' => '是否删除 0:否,1:是,2:全部'],
            ],
        ];
    }


    /**
     * 添加文章
     * @desc 鉴权接口：管理员
     * @return int       code 操作码0：成功，1：失败
     * @return string    msg  提示信息
     * @return int       id   新增文章id
     */
    public function Add(){
        $rs = ['code' => 0, 'msg' => 'success'];
        $re = self::$Domain->add($this);

        if($re==false){
            DI()->logger->debug('Article.Article error', $this);
            $rs['code'] = 1;
            $rs['msg'] = $re;
            return $rs;
        }
        $rs['id']=$re;
        return $rs;
    }

    /**
     * 添加文章
     * @desc 鉴权接口：管理员
     * @return int       code 操作码0：成功，1：失败
     * @return string    msg  提示信息
     */
    public function Edit(){
        $rs = ['code' => 0, 'msg' => 'success'];
        $re = self::$Domain->Edit($this);

        if($re==false){
            DI()->logger->debug('Article_Article.Edit error', $this);
            $rs['code'] = 1;
            $rs['msg'] = $re;
        }
        return $rs;
    }

    /**
     * 删除文章
     * @desc 鉴权接口：管理员
     * @return int       code 操作码0：成功，1：失败
     * @return string    msg  提示信息
     */
    public function Del(){
        $rs = ['code' => 0, 'msg' => 'success'];
        $re = self::$Domain->Del($this);

        if($re==false){
            DI()->logger->debug('Article_Article.Del error', $this);
            $rs['code'] = 1;
            $rs['msg'] = $re;
        }
        return $rs;
    }

    /**
     * 获取文章详情
     * @desc 免鉴权接口
     * @return int       code 操作码0：成功，1：不存在此文章
     * @return object    info                      内容对象数组
     * @return int       info.id                   文章id
     * @return string    info.title                文章标题
     * @return string    info.content              文章内容
     * @return int       info.cid                  类目id
     * @return int       info.type                 状态0:草稿,1:发布
     * @return int       info.isDel                是否删除 0:否,1:是
     * @return int       info.isHot                是否置顶 0:否 1:是
     * @return int       info.isComment            是否能评论 0:否 1:是
     * @return timestamp info.InsertTime           上传时间
     * @return timestamp info.UpdateTime           修改时间
     * @return string    msg  提示信息
     */
    public function Detail(){
        $rs = ['code' => 0, 'msg' => 'success'];
        $re = self::$Domain->Detail($this);

        if($re==false){
            $rs['code'] = 1;
            $rs['msg'] = $re;
        }
        $rs['info']=$re;
        return $rs;
    }

    /**
     * 获取文章列表(前台用)
     * @desc 免鉴权接口
     * @return int       code 操作码0：成功，1：不存在此文章
     * @return object    info                        内容对象数组
     * @return int       info[].id                   文章id
     * @return string    info[].title                文章标题
     * @return string    info[].content              文章内容
     * @return int       info[].cid                  类目id
     * @return int       info[].type                 状态0:草稿,1:发布
     * @return int       info[].isDel                是否删除 0:否,1:是
     * @return int       info[].isHot                是否置顶 0:否 1:是
     * @return int       info[].isComment            是否能评论 0:否 1:是
     * @return timestamp info[].InsertTime           上传时间
     * @return timestamp info[].UpdateTime           修改时间
     * @return string    msg                         提示信息
     */
    public function getList(){
        $rs = ['code' => 0, 'msg' => 'success'];
        $re = self::$Domain->getList($this);

        if($re==false){
            $rs['code'] = 1;
            $rs['msg'] = '文章列表为空';
            return $rs;
        }
        $rs['info']=$re;
        return $rs;
    }

    /**
     * 获取文章列表(管理员用)
     * @desc 鉴权接口：管理员
     * @return int       code 操作码0：成功，1：不存在此文章
     * @return object    info                        内容对象数组
     * @return int       info[].id                   文章id
     * @return string    info[].title                文章标题
     * @return string    info[].content              文章内容
     * @return int       info[].cid                  类目id
     * @return int       info[].type                 状态0:草稿,1:发布
     * @return int       info[].isDel                是否删除 0:否,1:是
     * @return int       info[].isHot                是否置顶 0:否 1:是
     * @return int       info[].isComment            是否能评论 0:否 1:是
     * @return timestamp info[].InsertTime           上传时间
     * @return timestamp info[].UpdateTime           修改时间
     * @return string    msg                         提示信息
     */
    public function getListAdmin(){
        $rs = ['code' => 0, 'msg' => 'success'];
        $re = self::$Domain->getListAdmin($this);

        if($re==false){
            $rs['code'] = 1;
            $rs['msg'] = '文章列表为空';
            return $rs;
        }
        $rs['info']=$re;
        return $rs;
    }






}