<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/1/001
 * Time: 23:48
 */
class Domain_User_Validate{

    public function ValidateMail($mailToken,$userid){
        $token=DI()->cache->get('ValidateMail_' . $userid);
        if($token==$mailToken){
            $userModel=new Model_User_User();
            $info=$userModel->edit(['id'=>$userid],['emailValidate'=>1]);
            if($info!==false){
                return true;
            }
            return false;
        }
        return false;
    }


}