<?php namespace Modules\AirClass\Http\Controllers;
use App\Models\Doctor;
use App\Models\Volunteer;
use App\Models\KZKTClass;
use Illuminate\Http\Request;
use Modules\AirClass\Entities\Banner;
use Modules\AirClass\Entities\Teacher;
use Modules\AirClass\Entities\ThyroidClass;
use Modules\AirClass\Entities\CourseClass;

use Modules\AirClass\Entities\CourseApplies;
use Modules\AirClass\Entities\ThyroidClassCourse;
use Modules\AirClass\Entities\ThyroidClassPhase;
use PhpParser\Comment\Doc;

class TestController extends Controller
{
    /**
     * 清理数据
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function index()
    {
        set_time_limit(0);
       // \Helper::tocurl(env('MD_USER_API_URL'). '/v2/query-user-information?phone='.$phone, null,0);

//        /* 批量doctor */
//        $users = \DB::table('doctors')
//            ->select('phone','id')
//            ->where('id', '<=', 8000)
//            ->where('id', '>=', 7000)
//            //->groupBy('phone')
//            //->having('phone', '>', 0)
//            ->get();
//
//        foreach ($users as $val)
//        {
//            $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/query-user-information?phone='.$val->phone, null,0);
//            if($response['httpCode']==200)
//            {
//                Doctor::where('phone', $val->phone)->update(['credit' => $response['result']['bean']['number']]);
//                echo($val->id.'update success'.PHP_EOL);
//            }
//            else
//                echo($val->id.'not exists'.PHP_EOL);
//        }
//        exit;
//
//        /* 批量同步志愿者 */
//        $users = \DB::table('volunteers')
//            ->select('phone','name','email')
//            //->groupBy('phone')
//            //->having('phone', '>', 0)
//            ->get();
//
//        foreach ($users as $val)
//        {
//            $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/query-user-information?phone='.$val->phone, null,0);
//            if($response['httpCode']==200)
//            {
//                Volunteer::where('phone', $val->phone)->update(['credit' => $response['result']['bean']['number']]);
//                echo($val->phone.'update success'.PHP_EOL);
//            }
//            else
//                echo($val->phone.'not exists'.PHP_EOL);
//        }
//        exit;

//        $array = ["15976452265","13827055421","13431797769","15363527636","13432294125","13750350395","13664984739","18575066248","13822371304","13750344146","13232877677","15815774083","13622570151","13536013069","13686968742","18138071601","13426806448","13544998626","13437306921","13664929943","15089810737","15975003015","15875082137","13802616763","15913686842","13427287748","18029617773","13426844749","13672825194","13686918221"];
//        foreach($array  as $val)
//        {
//            $model = \App\Models\Doctor::where(['phone'=>$val])->first();
//            if($model)
//            {
//                \App\Models\Doctor::where('phone', $val)->update(['password' => \Hash::make('123456')]);
//                echo $val.'ok'.'<br>';
//            }
//
//            else
//                echo $val.'不存在<br>';
//        }
//
//exit;
        $list  =  \DB::table('phone_talks')->where(['course_id'=>40])->get();
        foreach($list as $val)
        {
            $model = Doctor::where(['phone'=>$val->phone])->first();
            if($model)
            {
                $data= ['doctor_id'=>$model->id,'course_id'=>40,'site_id'=>2,'study_duration'=>$val->talk_time];
                $result = \App\Models\StudyLog::firstOrCreate($data);
                if($result)
                    echo $val->phone.'<br>';
            }
            else
                echo $val->phone.'不存在<br>';

        }

        exit;
        $list = Volunteer::all();
        foreach($list as $val)
        {
            $id = $val->id;
            $model = KZKTClass::where(['volunteer_id'=>$id])->first();
            if($model)
            {
                $count = KZKTClass::where(['volunteer_id'=>$id])->count();//
                try {
                    //赠送迈豆积分
                    $beans = $count*300;
                    $postdata = array('phone'=> $val->phone,'bean'=>$beans);
                    $res = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/modify-bean', $postdata,1);
                    if($res['httpCode']== 200)
                        echo("代表：".$val->phone.'赠送'.$beans).'<br>';

                } catch (\Exception $e) {
                    return $this->return_data_format(404, '服务器异常,操作失败!');
                }

            }

        }

        exit;

        /* 更新密码 */
        $prefix = '1910000';
        $default_password = \Hash::make('123456');
        for($i=1;$i<=60;$i++)
        {
            $var=sprintf("%04d", $i);
            $phone=$prefix.$var;// 测试手机号
            $model = \App\Models\Doctor::where(['phone'=>$phone])->first();
            $doctor_id = $model->id;
            \App\Models\KZKTClass::create(['volunteer_id'=>267,'doctor_id'=>$doctor_id,'site_id'=>2]);
            echo($phone.'报名完成'.'<br>');
            //\App\Models\Doctor::where(['phone'=>$phone]) ->update(['password' => $default_password]);
           // echo($phone.'ok'.'<br>');
        }


        exit;





        //$map = ['provincex' => ['LIKE' => '%湖北%']];
        $province = '湖北';
        $map =['province'=>['like', "%".$province."%"]];
        $list = \App\Models\Hospital::where($map)->get();
print_r($list);exit;
        /* 批量同步志愿者 */
        $users = \DB::table('volunteers')
            ->select('phone','name','email')
            ->where('id', '>', 7500)
            ->where('id', '<=', 11288)
            ->where('phone', '>', 0)
            //->groupBy('phone')
            //->having('phone', '>', 0)
            ->get();
        foreach ($users as $val)
        {
            $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/query-user-information?phone='.$val->phone, null,0);
            if($response['httpCode']==422)// 服务器返回响应状态码,当电话不存在时
            {
                /* 同步注册用户中心 */
                $post_data = array(
                    "name" => $val->name,
                    "phone" => $val->phone,
                    'email'=> $val->email,
                    'role'=>'volunteer',
                    'remark'=>'空中课堂',
                );
                $res = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/register', $post_data,1);
                if($res['httpCode']== 200)
                    echo($val->phone).'注册成功!'.'<br>';
                else
                    echo($val->phone).'已经存在!'.'<br>';
            }
        }
exit;
        $beansFee =1100;
        $beansFee = sprintf("%.2f", substr(sprintf("%.3f", $beansFee), 0, -2));

        /* 测试批量处理报名信息 */
        $res = \App\Models\Doctor::all();
        foreach($res as $val)
        {
            $doctor_id = $val->id;
            \App\Models\KZKTClass::create(['volunteer_id'=>11285,'doctor_id'=>$val->id,'site_id'=>2]);
            echo($val->phone.'报名完成'.'<br>');
        }

        exit;

        $prefix = '1910000';
        $default_password = \Hash::make('12345678');
        for($i=1;$i<=60;$i++)
        {
            $var=sprintf("%04d", $i);
            $phone=$prefix.$var;// 测试手机号
            $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/query-user-information?phone='.$phone, null,0);
            if($response['httpCode']==422)// 服务器返回响应状态码,当电话不存在时
            {
                /* 同步注册用户中心 */
                $api_to_uc_data = [
                    'phone' => $phone,
                    'password' => '12345678',
                    'office' => '内分泌科',
                    'title' => '主治医师',
                    'province' => '北京市',
                    'city' =>'北京市' ,
                    'hospital_name' => '北京人民医院',
                ];
                $api_to_uc = new ApiToUserCenterController();
                $api_to_uc_res = $api_to_uc->register($api_to_uc_data);
                if($api_to_uc_res['code'] == 200){
                    /* 保存医生信息 */
                    $add_doctor_data = [
                        'phone' => $phone,
                        'password' => $default_password,
                        'hospital_id' => 1,
                        'office' => '内分泌科',
                        'title' => '主治医师',
                    ];
                    $add_doctor = \App\Models\Doctor::create($add_doctor_data);

                    echo($phone.'注册成功!'.'<br>');
                }
                else
                    echo($phone.'已经存在!'.'<br>');

            }

        }

exit;
        \DB::table('doctors')->chunk(100, function($users) {
            foreach ($users as $val) {
                $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/query-user-information?phone='.$val->phone, null,0);
                if($response['httpCode']==422)// 服务器返回响应状态码,当电话不存在时
                {
                    \App\Models\Doctor::where('phone', $val->phone)->delete();
                    echo('电话:'.$val->phone .' 清理完毕 '."<br>");
                }
            }
        });
    }
	
}

