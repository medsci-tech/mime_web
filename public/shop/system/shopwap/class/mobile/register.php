<?php	
if (!defined("IN_IA")) {
    exit("Access Denied");
}
if(is_login_account())
{
header("location:".create_url('mobile',array('act' => 'center','do' => 'member','m'=>'eshop')));	
		exit;	
}    /**
 * 发送数据
 * @param String $url     请求的地址
 * @param int  $method 1：POST提交，0：get
 * @param Array  $data POST的数据
 * @return String
 * @author  lxhui
 */
function tocurl($url, $data,$method =0){
    $headers = array(
        "Content-type: application/json;charset='utf-8'",
        "Accept: application/json",
        "Cache-Control: no-cache","Pragma: no-cache",
    );
    try {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); //设置超时
        if(0 === strpos(strtolower($url), 'https')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //从证书中检查SSL加密算法是否存在
        }
        //设置选项，包括URL
        if($method) // post提交
        {
            curl_setopt($ch, CURLOPT_POST,  True);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        //释放curl句柄
        curl_close($ch);
        $response =json_decode($output,true);
        $response['httpCode'] = $httpCode;
    }
    catch (\Exception $e){
        $response = ['httpCode'=>500];
    }
    return $response;
}
//var_dump($_GP);die;
		if (checksubmit("submit")) {
			$mobile=$_GP['mobile'];
	
				$pwd=$_GP['newpassword'];
					$verify=$_GP['verify'];
						if(empty($verify))
					{
					message("请输入验证码！");	
					}
					$verify =strtolower($verify);
                    $url = 'http://'.$_SERVER['HTTP_HOST'].'/sms/check-code';
                    $result = tocurl('http://airclass.mime.org.cn/sms/check-code', array('phone'=>$mobile,'code'=>$verify),$method =1);

                    if($result['code']!==200)
					{
					message("验证码错误！",'refresh','error');
					}
            if(empty($mobile))
			{
					message("请输入手机号！");	
			}
			/* 检查手机合法性 */
            $doctor = mysqld_select("SELECT * FROM mime_doctors"." where phone=:mobile", array(':mobile' => $mobile));
            $volunteer = mysqld_select("SELECT * FROM mime_volunteers"." where phone=:mobile", array(':mobile' => $mobile));
            if(!$doctor && !$volunteer) //医生
            {
                message("手机号不存在！");
            }
            if($doctor)
                $user_type=2;
            else
                $user_type=1;

            $userData = $doctor ? $doctor :$volunteer ;
            $userData['user_type'] = $user_type;
            $member = mysqld_select("SELECT * FROM ".table('base_member')." where mobile=:mobile  and beid=:beid", array(':mobile' => $mobile,':beid'=>$_CMS['beid']));

				if(!empty($member['openid']))
			{
                if($userData)
                {
                    mysqld_update('eshop_member', array('credit1' =>$userData['credit'],'credit2' =>$userData['credit']),array('openid'=>$member['openid']));
                }
			}

		$doaction=true;
					$settings=globalSetting('sms');
		if(!empty($settings['regsiter_usesms']))
		{
				 	require(WEB_ROOT.'/includes/lib/lib_sms.php'); 
		}
		if(!empty($settings['regsiter_usesms'])&&!empty($settings['sms_register_user'])&&!empty($settings['sms_register_user_signname']))
		{
			$doaction=false;
				if(!empty($_GP['fromsmspage']))
			{
					if(empty($_GP['mobilecode']))
					{
						message("验证码不能空");	
					}
					
						  $vcode_check=system_sms_validate($mobile,'register_user',$_GP['mobilecode']);
						  if( $vcode_check)
						  {
						    $doaction=true;	
						  }else
						  {
						  	  message("验证码错误");
						  }
			}else
			{
                $shop_regcredit=intval($cfg['shop_regcredit']);
                $oldsessionid=get_sysopenid(false);
                $pwd='123456789';//默认
                $insertData=[];
                $openid=member_create_new($mobile,$pwd,$userData);

                //member_credit($openid,$shop_regcredit,"addcredit","注册系统赠送积分");


                save_member_login($openid);

                message('登录成功！', gologinfromurl(), 'success');

					 // 	include page('register_smscheck');
					  //	exit;
			}
		}

		if($doaction)
		{
		$shop_regcredit=intval($cfg['shop_regcredit']);
		

		$oldsessionid=get_sysopenid(false);

				$openid=member_create_new($mobile,$pwd);
		
				
		
				if(!empty($shop_regcredit))
				{
				member_credit($openid,$shop_regcredit,"addcredit","注册系统赠送积分");
				}
				
	
					
				save_member_login($openid);
	
			  message('注册成功！', gologinfromurl(), 'success');
			}
		}
	if(is_use_weixin()&&($_GP['op']!='account'))
				{
					$isregister=true;
					    include page('login_weixin');	
					    exit;
				}
        include page('register');	