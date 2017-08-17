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
                DI()->cache->delete('ValidateMail_' .$userid);//删除缓存
                return true;
            }
            return false;
        }
        return false;
    }

    public function ChagenPasswordSend($email){
        $userModel=new Model_User_User();
        $info=$userModel->getOne(['email'=>$email]);
        if(!$info){
            return 1;//该邮箱未注册
        }
        if($info['emailValidate']==0){
            return 2;//该邮箱未通过认证
        }
        $token=MD5(date('Y-M-D HH:ii:ss',time()).'ChagenPasswordSend'.rand(1000000,9999999));
        DI()->cache->set('changepassword_mail' . $info['id'], $token, 1800);
        $data1=[
            'time'=>date('Y-m-d H:i:s'),
            'date'=>date('Y年m月d日'),
            'link'=>DI()->config->get('app.domain').'changepassword.html?mailToken='.$token.'&uid='.$info['id'],
        ];
        DI()->mail->send($info['email'],0,$data1);
        return 0;
    }

    public function ChagenPasswordReceive($mailToken,$userid,$password){
        $token=DI()->cache->get('changepassword_mail' . $userid);
        if(!$token||$token!=$mailToken){
            return 1;//无效链接
        }
        $userModel=new Model_User_User();
        $info=$userModel->edit(['id'=>$userid],['password'=>MD5($password)]);
        if($info){
            DI()->cache->delete('changepassword_mail' .$userid);//删除缓存
            return 0;
        }
        return 2;
    }


}