<?php
/**
 * 邮件工具类
 *
 * - 基于PHPMailer的邮件发送
 *
 *  配置
 *
 * 'PHPMailer' => array(
 *   'email' => array(
 *       'host' => 'smtp.gmail.com',
 *       'username' => 'XXX@gmail.com',
 *       'password' => '******',
 *       'from' => 'XXX@gmail.com',
 *       'fromName' => 'PhalApi团队',
 *       'sign' => '<br/><br/>请不要回复此邮件，谢谢！<br/><br/>-- PhalApi团队敬上 ',
 *   ),
 * ),
 *
 * 示例
 *
 * $mailer = new PHPMailer_Lite(true);
 * $mailer->send('chanzonghuang@gmail.com', 'Test PHPMailer Lite', 'something here ...');
 *
 * @author dogstar <chanzonghuang@gmail.com> 2015-2-14
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR . 'PHPMailerAutoload.php';

class PHPMailer_Lite
{
    protected $debug;

    protected $config;

    public function __construct($debug = FALSE) {
        $this->debug = $debug;

        $this->config = DI()->config->get('email.PHPMailer.email');
    }

    /**
     * 发送邮件
     * @param array/string $addresses 待发送的邮箱地址
     * @param int    $template 邮件模版
     * @param array  $param  模板所需参数
     * @param boolean $isHtml 是否使用HTML格式，默认是
     * @return boolean 是否成功
     */
    public function send($addresses, $template, $param, $isHtml = TRUE)
    {
        $mail = new PHPMailer;
        $cfg = $this->config;

        $mail->isSMTP();
        $mail->Host = $cfg['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $cfg['username'];
        $mail->Password = $cfg['password'];
        $mail->CharSet = 'utf-8';

        $mail->From = $cfg['username'];
        $mail->FromName = $cfg['fromName'];
        $addresses = is_array($addresses) ? $addresses : array($addresses);
        foreach ($addresses as $address) {
            $mail->addAddress($address);
        }

        $mail->WordWrap = 50;
        $mail->isHTML($isHtml);

        $title=DI()->config->get("email.template.{$template}.title");
        if(!$title){
            return false;
        }
        $content=$this->getMailParam($template,$param);

        $mail->Subject = trim($title);
        $mail->Body = $content . $cfg['sign'];

        if (!$mail->send()) {
            if ($this->debug) {
                DI()->logger->debug('Fail to send email with error: ' . $mail->ErrorInfo);
            }

            return false;
        }

        if ($this->debug) {
            DI()->logger->debug('Succeed to send email', array('addresses' => $addresses, 'title' => $title));
        }

        return true;
    }

    /**
     * 获取推送详情
     * @param $template
     * @param $params
     */
    function getMailParam($template,$params){
        $content = DI()->config->get("email.template.{$template}.content");
        if(!$params){
            return $content;
        }
        $names = array_keys($params);
        $names = array_map(function ($name) {
            return '${' . $name . '}';
        }, $names);
        return str_replace($names, array_values($params), $content);
    }
}

