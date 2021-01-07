<?php


namespace oreo\extend;

class Sms
{
    protected static $result;

    protected static $mail = array();
    /**
     * 腾讯云短信
     * @author oreo<609451870@qq.com>
     * @param string $appId
     * @param string $appKey
     * @return sms\qcloud\SmsSingleSender
     */
    public function qCloudSms(string $appId, string $appKey) {
        $qCloud =  new \oreo\extend\sms\qcloud\SmsSingleSender($appId, $appKey);
        return self::$result = $qCloud;
    }

    /**
     * 指定模板单发
     * @author oreo<609451870@qq.com>
     *
     * @param string $nationCode  国家码，如 86 为中国
     * @param string $phoneNumber 不带国家码的手机号
     * @param int    $tempId      模板 id
     * @param string $param       模板参数列表，如模板 {1}...{2}...{3}，那么需要带三个参数
     * @param string $sign        签名，如果填空串，系统会使用默认签名
     * @param string $extend      扩展码，可填空串
     * @param string $ext         服务端原样返回的参数，可填空串
     * @return string 应答json字符串，详细内容参见腾讯云协议文档
     */
    public function qCloudSmsParam($nationCode, $phoneNumber, $tempId = 0, $param, $sign = "", $extend = "", $ext = ""){
        $params = ["$param"];
        try {
            $res = self::$result->sendWithParam("$nationCode", $phoneNumber, $tempId, $params, $sign, "", "");
            self::$result = null;
            return json_decode($res,true);
        } catch (\Exception $e){
            return json_decode($e->getMessage(),true);
        }
    }

    /**
     * 阿里云短信发送
     * @author oreo<609451870@qq.com>
     * @param string $accessKeyId     AccessKeyId
     * @param string $accessKeySecret AccessKeySecret
     * @param string $signName        签名内容
     * @param string $templateCode    短信模板CODE
     * @return sms\aliyun\AliSms
     */
    public function aliSms(string $accessKeyId, string $accessKeySecret, string $signName, string $templateCode) {
        $config = array (
            'accessKeyId'     => $accessKeyId,
            'accessKeySecret' => $accessKeySecret,
            'signName'        => $signName,
            'templateCode'    => $templateCode
        );
        $ali =  new \oreo\extend\sms\aliyun\AliSms($config);
        return self::$result = $ali;
    }

    /**
     * 阿里云短信
     * @author oreo<609451870@qq.com>
     * @param string $phone 短信接受手机号码
     * @param string $param 数字验证码
     * @return mixed
     */
    public function aliSmsParam(string $phone,string $param) {
        try {
            $res = self::$result->send_verify($phone,$param);
            self::$result = null;
            return json_decode($res,true);
        }catch (\Exception $e){
            return json_decode($e->getMessage(),true);
        }
    }

    /**
     * SMTP邮件发送
     * @author oreo<609451870@qq.com>
     * @param string $smtp_url SMTP地址
     * @param int    $smtp_port SMTP端口 465或25
     * @param string $mail_name 发件邮箱账号
     * @param string $mail_pass 发件邮箱密码
     * @param string $alias     别名(可选)
     */
    public function email(string $smtp_url, int $smtp_port = 465, string $mail_name, string $mail_pass, string $alias){
        $mail = new \oreo\extend\sms\sendmail\SendClass($smtp_url,$smtp_port,1,$mail_name,$mail_pass,$smtp_port==465?1:0);
        self::$mail['email_name'] = $mail_name;
        self::$mail['alias'] = $alias;
        self::$result = $mail;
    }

    /**
     * SMTP邮件发送其他配置
     * @author oreo<609451870@qq.com>
     * @param string $email 收件邮箱
     * @param string $title 邮件标题
     * @param string $text  邮件内容
     * @return mixed
     */
    public function emailParam(string $email, string  $title, string $text){
        $res = self::$result->send($email,self::$mail['email_name'],$title,$text,self::$mail['alias']);
        self::$result = null;
        self::$mail = null;
        return json_decode($res,true);
    }

}