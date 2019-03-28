<?php
namespace Zejicrm\Modules\Backend\Controllers;

class ApiController extends ControllerBase
{

    private $common=array(
        '[公共平台类型]platform'=>'int[ 1-ios 2-android  3-windowphone 4-pc 5-browser]',
        '[公共平台channel]channel'=>'int[]',
//        '[公共设备号]device_id'=>'string',
//        '[公共登陆ID]login_id'=>'int[未登入：0]',
//        '[公共版本号]version'=>'string',
        '[公共时间戳]timestamp'=>'int',
        '[公共渠道]vendor'=>'init',

    );
    public function testAction()
    {
       $data=array(
           //------------------------------------------
           '【测试接口】'.'/index/get'=>array(
                '【请求参数】request'=>array(
                    'data'=>array_merge($this->common,
                        array(
                            'id'=>'int',
                        )
                    ),
                ),
                '【返回参数】response'=>array(
                    'code'=>'',
                    'msg'=>'',
                    'data'=>array(
                    )
                )
            ),
           //------------------------------------------
       );
       die(json_encode($data));
    }


}

