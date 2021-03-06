<?php

/**
 * @author xialei <xialeistudio@gmail.com>
 */
class K3Cloud_Sync
{
    private static $k3cloud_instance;
    const REQ_GET = 1;
    const REQ_POST = 2;
    const CLOUD_URL  = "http://123.183.136.65:8090/K3Cloud/";
    /**
     * 单例模式
     * @return map
     */
    public static function instance()
    {
        if (!self::$k3cloud_instance instanceof self)
        {
            self::$k3cloud_instance = new self;
        }
        return self::$k3cloud_instance;
    }

    public function login($username ,$password){
       // $cloudUrl = "http://123.183.136.65:8090/K3Cloud/Kingdee.BOS.WebApi.ServicesStub.AuthService.ValidateUser.common.kdsvc";

        //登陆参数
        $data = array(
            'acctID' => '59f866a999c091',//帐套Id 正式
            'username' => 'admin',//用户名
            'password' => 'ygf118',//密码
            'lcid' => 2052//语言标识
        );
        $cookie_jar = tempnam(DATA_PATH ,'CloudSession');
        $post_content = create_postdata($data);

        $result = invoke_login(self.CLOUD_URL,$post_content,$cookie_jar);


//        $resp = $this-> async($cloudUrl,$data,true,self.REQ_GET);
//
//        $array = json_decode($resp,true);
        return $result;
    }

    //登陆
    function invoke_login($cloudUrl,$post_content,$cookie_jar)
    {
        $loginurl = $cloudUrl.'Kingdee.BOS.WebApi.ServicesStub.AuthService.ValidateUser.common.kdsvc';
        return invoke_post($loginurl,$post_content,$cookie_jar,TRUE);
    }

    //保存
    function invoke_save($cloudUrl,$post_content,$cookie_jar)
    {
        $invokeurl = $cloudUrl.'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Save.common.kdsvc';
        return invoke_post($invokeurl,$post_content,$cookie_jar,FALSE);
    }

    //审核
    function invoke_audit($cloudUrl,$post_content,$cookie_jar)
    {
        $invokeurl = $cloudUrl.'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Audit.common.kdsvc';
        return invoke_post($invokeurl,$post_content,$cookie_jar,FALSE);
    }

    function invoke_post($url,$post_content,$cookie_jar,$isLogin)
    {
        $ch = curl_init($url);

        $this_header = array(
            'Content-Type: application/json',
            'Content-Length: '.strlen($post_content)
        );

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($isLogin){
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
        }
        else{
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    //构造Web API请求格式
    function create_postdata($args) {
        $postdata = array(
            'format'=>1,
            'useragent'=>'ApiClient',
            'rid'=>create_guid(),
            'parameters'=>$args,
            'timestamp'=>date('Y-m-d'),
            'v'=>'1.0'
        );
        return json_encode($postdata);
    }

    //生成guid
    function create_guid() {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}