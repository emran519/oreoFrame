<?php

namespace controller;

use oreo\extend\Sms;
use oreo\lib\Controller;
use oreo\lib\Db;
class Test extends Controller
{

    //数据库查询实例
    public function sql(){
        $username = request()->get('name');
        $res = Db::table('test') //表名
            ->where("username",$username) // 键名--值
            ->find(); // find()单条 all() 全部
        responseType("json");
        return ['code'=>200,'data'=>$res];
    }

    //获取系统变量实例
    public function getSystem(){
        return $this->systemInfo('web_name');
    }

    //腾讯云短信-调用实例
    public function qcloudSms(){
        //获取传来的电话号码
        $phone = request()->get('phone');
        //验证码
        $param = rand(111111,999999);
        //实例化短信类
        $sms = new Sms();
        //第一个参数为 appId， 第二个参数为 Key
        $sms->qCloudSms('','');
        //设置其他配置(1.国家码，国内不用改 2.接受短信手机号码 3.模板ID 4.数字验证码 5.短信签名)
        $res = $sms->qCloudSmsParam("86",$phone,'',$param,'');
        //res返回 json数据， result=0 表示发送成功
        //var_dump($res);die();
        if($res['result']===0){
            return json(200,'ok','发送成功,请注意查收');
        }else{
            return json(0,'error','发送失败');
        }
    }

    //阿里云短信-调用实例
    public function aliSms(){
        //获取传来的电话号码
        $phone = request()->get('phone');
        //验证码
        $param = rand(111111,999999);
        //实例化短信类
        $sms = new Sms();
        //设置其他配置(1.AccessKeyId 2.AccessKeySecret 3.签名内容 4.短信模板CODE)
        $sms->aliSms('','','','');
        $res = $sms->aliSmsParam($phone, $param);
        return $res;
    }

    //邮件发送实例
    public function email(){
        //获取传来的邮箱
        $email = request()->get('email');
        //实例化短信类
        $sms = new Sms();
        //基本配置(1.SMTP地址 2.SMTP端口 一般465或25 3.邮箱账号 4.邮箱密码 5.别名，可以写网站名称(可选))
        $sms->email('','', '' ,'','');
        //设置其他配置(1.收件邮箱 2.邮件标题 3.邮件内容)
        $res = $sms->emailParam($email,'这是测试标题','这是测试内容 Oreo微框架');
        //var_dump($res);
        if($res==true){
            return json(200,'ok','发送成功,请注意查收');
        }else{
            return json(0,'error','发送失败');
        }
    }


}