<?php
namespace Zejicrm\config;

class Mobile {
    
    //生成验证码长度
    const Mobile_Verify_Len = 4;
    //第二次发送间隔时间
    const Mobile_Gap_Time = 60;
    //验证码有效期
    const Mobile_Verify_Time = 600;
    
    //单手机号每天限制数量
    const Mobile_Today_Max_Num = 20;
    //单IP每小时最大限制次数
    const Mobile_IP_Max_Num = 10;
    //单IP每小时最大限制次数
    const Mobile_IP_Active_Max_Num = 1000;

    
    /* 获取验证码缘由 */
    public static $getVerifyCode = array(
        'register' => 1,        //注册
        'find_passwd' => 2,     //找回密码
        'bind_mobile' => 3,     //绑定手机号
        //'change_mobile' => 4,   //修改手机号
        'find_paypwd'=>4,//找回支付密码
        'login'=>5,//短信登录,
        'common_sendcode'=>6,
    );


    public static $smsConfig = array(
        'signName'=>[
            'zejiwangxiao'=>'泽稷网校',
            'zejiedu'=>'泽稷教育'
        ],
        'url' => 'http://yunpian.com/v1/sms/send.json',
        'apikey' => '071c03663c0415d052a1ec0a1d4d0f6c',
        //yunpan
        'template_1' => '【泽稷网校】感谢您的注册，您的验证码是%s，该验证码30分钟内有效。',
        'template_2' => '【泽稷网校】提示您现在正在重置登录密码，您的验证码是%s，该验证码30分钟内有效。',
        'template_3' => '【泽稷网校】提示您现在正在修改绑定的手机号，您的验证码是%s，该验证码30分钟内有效。',
        'template_4' => '【泽稷网校】提示您现在正在修改虚拟币支付密码，您的验证码是%s，该验证码30分钟内有效。',
        'template_5' => '【泽稷网校】您的登录验证码是%s，有效期为30分钟。',
        'template_6' => '【泽稷网校】您的验证码是${code}，该验证码30分钟内有效。',

        //ali
        /* 通用验证码模板：您的验证码是${code}，该验证码30分钟内有效。 */
        'template1'=>[
            'code'=>'SMS_129748976',
            'code_gw'=>'SMS_138067094',
            'text'=>'您的验证码是${code}，该验证码30分钟内有效。'
        ],
        /* 注册验证码模板：感谢您的注册，您的验证码是${code}，该验证码30分钟内有效。 */
        'template2'=>[
            'code'=>'SMS_129743952',
            'code_gw'=>'SMS_138077049',
            'text'=>'感谢您的注册，您的验证码是${code}，该验证码30分钟内有效。'
        ],
        /* 登录验证码模板：您的登录验证码是${code}，有效期为30分钟。 */
        'template3'=>[
            'code'=>'SMS_129744029',
            'code_gw'=>'SMS_138067097',
            'text'=>'您的登录验证码是${code}，有效期为30分钟。'
        ],
        /* 预约班级模板：亲爱的学员，恭喜您成功预约${name}课程的选课，请您保存好上课时间表，开课前一周班主任会告知授课地点。有任何问题请咨询各自班主任。谢谢配合。 */
        'template4'=>[
            'code'=>'SMS_130915479',
            'text'=>'亲爱的学员，恭喜您成功预约${name}课程的选课，请您保存好上课时间表，开课前一周班主任会告知授课地点。有任何问题请咨询各自班主任。谢谢配合。'
        ],
        /* 直播提醒短信：您预约的直播课《${name}》将于${time}开始，您可以登录泽稷网校或泽稷APP进行观看。 */
        'template5'=>[
            'code'=>'SMS_130921205',
            'text'=>'您预约的直播课《${name}》将于${time}开始，您可以登录泽稷网校或泽稷APP进行观看。'
        ],
        /* 上课提醒短信：您的《${name}》将于${time}开始，您可以登录泽稷网校或泽稷APP进行观看。 */
        'template6'=>[
            'code'=>'SMS_130911193',
            'text'=>'您的《${name}》将于${time}开始，您可以登录泽稷网校或泽稷APP进行观看。'
        ],
        /* 上课提醒短信：您的《${name}》将于今天${time}开始，您可以登录泽稷网校或泽稷APP进行观看，请提前5分钟进入直播教室准备上课。 */
        'template7'=>[
            'code'=>'SMS_130916207',
            'text'=>'您的《${name}》将于今天${time}开始，您可以登录泽稷网校或泽稷APP进行观看，请提前5分钟进入直播教室准备上课。'
        ],
        /* 开课提示短信 */
        'template8'=>[
            'code'=>'SMS_129764568',
            'text'=>'\'${tname}\'正在为\'${sname}\'(手机号${tel})开课，备注\'${text}\'，课程名\'${course}\'，编码为${code}。'
        ],
        /* 第三方兑换码 */
        'template9'=>[
            'code'=>'SMS_129764726',
            'text'=>'亲，您在${text}购买的课程兑换码为：${code}，请您点击链接：www.zejicert.cn/fastcode ，进行注册登录和课程兑换。'
        ],
        /* 机考报名通知 */
        'template10'=>[
            'code'=>'SMS_132391410',
            'text'=>'${name}同学你已成功报名泽稷ACCA机考考试，考场为${room}，考试时间为${time}，考试科目为${course}，请到泽稷网校机考报名界面查看报名详情并打印考试确认书，点击链接跳转查看www.zejicert.cn/quizsign/list'
        ],
        /* 重置密码的验证码 */
        'template11'=>[
            'code'=>'SMS_129759024',
            'code_gw'=>'SMS_138077169',
            'text'=>'提示您现在正在重置登录密码，您的验证码是${code}，该验证码30分钟内有效。'
        ],
        /* 修改手机号验证码 */
        'template12'=>[
            'code'=>'SMS_129764008',
            'code_gw'=>'SMS_138062300',
            'text'=>'提示您现在正在修改绑定的手机号，您的验证码是${code}，该验证码30分钟内有效。'
        ],
        /* 虚拟币支付密码验证码 */
        'template13'=>[
            'code'=>'SMS_129764005',
            'code_gw'=>'SMS_138077166',
            'text'=>'提示您现在正在修改虚拟币支付密码，您的验证码是${code}，该验证码30分钟内有效。'
        ],

    );



    // 获取模版code
    public static function getTemplateCode($code){
        switch ($code){
            case 'register':
            case '1':
                $templateCode = 'template2';
                break;
            case 'login':
            case '5':
                $templateCode = 'template3';
                break;
            case 'forgetLogin':
            case '2':
                $templateCode = 'template11';
                break;
            case 'editPhone':
            case '3':
                $templateCode = 'template12';
                break;
            case 'payPwd':
            case '4':
                $templateCode = 'template13';
                break;
            case '6':
                $templateCode = 'template1';
                break;
        }
        return $templateCode;
    }

}