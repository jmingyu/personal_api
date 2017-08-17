<?php
/**
 * Created by JiangMingyu.
 * User: JiangMingyu
 * E-mail: jmingyu@qq.com
 * Date: 2017/8/14/014
 * Time: 23:06
 */
return [
    //邮件工具类配置
    'PHPMailer' => [
        'email' => [
            'host' => 'smtp.163.com',
            'username' => 'jmingyu99@163.com',
            'password' => '10042817jmy',
            'from' => 'jmingyu99@163.com',
            'fromName' => '128娱乐城',
            'sign' => '',
        ],
    ],
    'template'=>[
        //绑定邮箱
        0=>[
            'title'=> '128娱乐城-绑定邮箱',
            'content'=>'
            <table width="650" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-size: 14px;font-family: 宋体;line-height: 30px">
                            亲爱的用户：
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;font-family: 宋体;line-height: 30px">
                            您好! 我们收到您于 ${time} 提交的绑定邮箱请求。
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;font-family: 宋体;line-height: 30px">
                            请点击链接完成绑定邮箱设置（链接60分钟内有效）：
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="${link}" style="font-size: 14px;font-family: 宋体;line-height: 30px;color: #1e5494;text-decoration: underline">
                                ${link}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;font-family: 宋体;line-height: 30px;color: #a4a4a4">
                            如果以上链接无法点击，请将上述链接地址复制到浏览器的地址栏进入。
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;font-family: 宋体;line-height: 30px;text-align: right">
                            128娱乐城
                        </td>
                    </tr>
                        <td style="font-size: 14px;text-align: right;font-family: 宋体;line-height: 30px;text-align: right;text-decoration: dashed">
                            ${date}
                        </td>
                </table>
        ',
        ],
        //找回密码
        1=>[
            'title'=> '128娱乐城-绑定邮箱',
            'content'=>'
            <table width="650" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-size: 14px;font-family: 宋体;line-height: 30px">
                            亲爱的用户：
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;font-family: 宋体;line-height: 30px">
                            您好! 我们收到您于 ${time} 提交的修改密码请求。
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;font-family: 宋体;line-height: 30px">
                            请点击链接完成绑定邮箱设置（链接60分钟内有效）：
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="${link}" style="font-size: 14px;font-family: 宋体;line-height: 30px;color: #1e5494;text-decoration: underline">
                                ${link}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;font-family: 宋体;line-height: 30px;color: #a4a4a4">
                            如果以上链接无法点击，请将上述链接地址复制到浏览器的地址栏进入。
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;font-family: 宋体;line-height: 30px;text-align: right">
                            128娱乐城
                        </td>
                    </tr>
                        <td style="font-size: 14px;text-align: right;font-family: 宋体;line-height: 30px;text-align: right;text-decoration: dashed">
                            ${date}
                        </td>
                </table>
        ',
        ],

    ]
];