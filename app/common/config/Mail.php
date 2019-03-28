<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2018/12/5
 * Time: 13:30
 */

namespace Zejicrm\config;

class Mail {
        const TITLE_SETTING_ACCOUNT="有%d条数据已经分配给您";
        const TITLE_CUSTOMER_KIND_CHANGE="客户:%s转入%s客户,报名项目:%s,招生老师:%s;";
        const TITLE_ORDER_INFO="订单编号:%s,订单:%s";
        const TITLE_ORDER_NEED_SEND_GIVEAWAY="需要发放赠品;";
        const TITLE_ORDER_NEED_MAKE_INVOICE="需要开票;";
        const TITLE_ORDER_NEED_MODIFY_INVOICE="开票信息更改;";
        const TITLE_ORDER_CANCEL_INVOICE="取消开票;";
        const TITLE_ORDER_HAS_NEW="有新订单需要跟进,报名项目:%s,招生老师:%s;";


        const TITLE_SUIHAO="税号:%s";
        const BODY_SUIHAO_EXTRA="地址:%s;电话:%s;开户行:%;企业账号:%;";

        const TITLE_GIVEAWAY_GET_INFO="赠品领取:%s;";
        const TITLE_GIVEAWAY_GET_CHANGE_TIME="领取的截止时间为:%s;";
        const TITLE_GIVEAWAY_GET_CHANGE_STATUS="状态修改为:%s;";


        const TITLE_INVOICE_GET_INFO="发票领取:%s;";
        const TITLE_INVOICE_GET_CHANGE_TIME="领取的截止时间为:%s;";
        const TITLE_INVOICE_GET_CHANGE_STATUS="状态修改为:%s;";

        const TITLE_ORDER_REFUND_HAS_FINISH="用户名%s,订单%s,退款状态:%s;";
        const TITLE_ORDER_APPLY_REFUND="订单:%s、订单名:%s申请退款";
        const TITLE_ORDER_CANCEL_APPLY_REFUND="订单:%s、订单名:%s取消退款";

        const BODY_CUSTOMER_KIND_CHANGE="客户:%s;手机:%s";
        const BODY_ORDER_BUY_1="用户%s,订购%s,";
        const BODY_ORDER_NEED_SEND_GIVEAWAY="需要发放%s;";

        const BODY_ORDER_NEED_MAKE_INVOICE="类型:%s,抬头:%s,产品:%s,金额%.2f;";

        const BODY_ORDER_REFUND_HAS_FINISH="订单编号%d;订单名%s;用户名%s;退款状态:%s;退款预计时间:%s;实际退款时间:%s;";

        const BODY_ORDER_FEFUND_INFO="订单标题:%s,订单用户:%s,订单价格:%.2f;退款金额:%.2f;";


}