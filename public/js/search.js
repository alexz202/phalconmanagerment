/**
 * Created by zhualex on 16/3/7.
 */

$(function(){

    initsearch();

    function initsearch(){
        var key=$('#selectSt').val();
        $('.cscommon').each(function(){
            var id=$(this).attr('id');
            if(id=="dcs_"+key){
                $(this).show();
                $(this).find('.form-control').attr("disabled", false);
            }else{
                $(this).hide();
                $(this).find('.form-control').attr("disabled", true);
            }
        });
    }

    //普通搜索聚合
    $('#selectSt').change(function(){
        var key=$(this).val();
        $('.cscommon').each(function(){
            var id=$(this).attr('id');
            if(id=="dcs_"+key){
                $(this).show();
                $(this).find('.form-control').attr("disabled", false);
            }else{
                $(this).hide();
                $(this).find('.form-control').attr("disabled", true);
            }
        });
    })

    $('.selectTimeSuit').change(function () {
        var start_time=null;
        var end_time=null;
        var type=parseInt($(this).val());
        if(type==1){
            //今天
            start_time= getDate(0)+" 00:00:00";
            end_time= getDate(0)+" 23:59:59";

        }else if(type==2){
            //昨天
            start_time= getDate(-1)+" 00:00:00";
            end_time= getDate(-1)+" 23:59:59";

        }else if(type==3){
            //明天
            start_time= getDate(1)+" 00:00:00";
             end_time= getDate(1)+" 23:59:59";

        }else if(type==4){
            //本周

             start_time= getMonday('s',0)+" 00:00:00";
                end_time= getMonday('e',0)+" 23:59:59";

        }else if(type==5){
            //上周

            start_time= getMonday('s',-1)+" 00:00:00";
             end_time= getMonday('e',-1)+" 23:59:59";

        }else if(type==6){
            //下周
            start_time= getMonday('s',1)+" 00:00:00";
            end_time= getMonday('e',1)+" 23:59:59";

        }else if(type==7){
            //本月
            start_time= getMonth('s',0)+" 00:00:00";
            end_time= getMonth('e',0)+" 23:59:59";

        }else if(type==8){
            //上月
            start_time= getMonth('s',-1)+" 00:00:00";
            end_time= getMonth('e',-1)+" 23:59:59";

        }else if(type==9){
            //下月
            start_time= getMonth('s',1)+" 00:00:00";
            end_time= getMonth('e',1)+" 23:59:59";

        }else if(type==10){
            //今年
            start_time= getYear('s',0)+" 00:00:00";
            end_time= getYear('e',0)+" 23:59:59";
        }else if(type==11){
            //去年
            start_time= getYear('s',-1)+" 00:00:00";
            end_time= getYear('e',-1)+" 23:59:59";
        }

        if(start_time!=null && end_time!=null){
            var key=$(this).data().key;
            console.log(key);
            $('#start'+key).val(start_time);
            $('#'+key).val(end_time);
        }

    });


    $('.gselectTimeSuit').change(function () {

        var start_time=null;
        var end_time=null;
        var type=parseInt($(this).val());
        if(type==1){
            //今天
            start_time= getDate(0)+" 00:00:00";
            end_time= getDate(0)+" 23:59:59";

        }else if(type==2){
            //昨天
            start_time= getDate(-1)+" 00:00:00";
            end_time= getDate(-1)+" 23:59:59";

        }else if(type==3){
            //明天
            start_time= getDate(1)+" 00:00:00";
            end_time= getDate(1)+" 23:59:59";

        }else if(type==4){
            //本周

            start_time= getMonday('s',0)+" 00:00:00";
            end_time= getMonday('e',0)+" 23:59:59";

        }else if(type==5){
            //上周

            start_time= getMonday('s',-1)+" 00:00:00";
            end_time= getMonday('e',-1)+" 23:59:59";

        }else if(type==6){
            //下周
            start_time= getMonday('s',1)+" 00:00:00";
            end_time= getMonday('e',1)+" 23:59:59";

        }else if(type==7){
            //本月
            start_time= getMonth('s',0)+" 00:00:00";
            end_time= getMonth('e',0)+" 23:59:59";

        }else if(type==8){
            //上月
            start_time= getMonth('s',-1)+" 00:00:00";
            end_time= getMonth('e',-1)+" 23:59:59";

        }else if(type==9){
            //下月
            start_time= getMonth('s',1)+" 00:00:00";
            end_time= getMonth('e',1)+" 23:59:59";

        }else if(type==10){
            //今年
            start_time= getYear('s',0)+" 00:00:00";
            end_time= getYear('e',0)+" 23:59:59";
        }else if(type==11){
            //去年
            start_time= getYear('s',-1)+" 00:00:00";
            end_time= getYear('e',-1)+" 23:59:59";
        }

        if(start_time!=null && end_time!=null){
            var key=$(this).data().key;
            $('#gstart'+key).val(start_time);
            $('#g'+key).val(end_time);
        }

    });



     function getDate(dates) {
         //dates为数字类型，0代表今日,-1代表昨日，1代表明日，返回yyyy-mm-dd格式字符串，dates不传默认代表今日。
         var dd = new Date();
         var n = dates || 0;
         dd.setDate(dd.getDate() + n);
         var y = dd.getFullYear();
         var m = dd.getMonth() + 1;
         var d = dd.getDate();
         m = m < 10 ? "0" + m: m;
         d = d < 10 ? "0" + d: d;
         var day = y + "-" + m + "-" + d;
         return day;
     };



    function getMonday(type, dates) {
        var now = new Date();
        var nowTime = now.getTime();
        var day = now.getDay();
        var longTime = 24 * 60 * 60 * 1000;
        var n = longTime * 7 * (dates || 0);
        if (type == "s") {
            var dd = nowTime - (day - 1) * longTime + n;
        };
        if (type == "e") {
            var dd = nowTime + (7 - day) * longTime + n;
        };
        dd = new Date(dd);
        var y = dd.getFullYear();
        var m = dd.getMonth() + 1;
        var d = dd.getDate();
        m = m < 10 ? "0" + m: m;
        d = d < 10 ? "0" + d: d;
        var day = y + "-" + m + "-" + d;
        return day;
    };


    function getMonth(type, months) {
        var d = new Date();
        var year = d.getFullYear();
        var month = d.getMonth() + 1;
        if (Math.abs(months) > 12) {
            months = months % 12;
        };
        if (months != 0) {
            if (month + months > 12) {
                year++;
                month = (month + months) % 12;
            } else if (month + months < 1) {
                year--;
                month = 12 + month + months;
            } else {
                month = month + months;
            };
        };
        month = month < 10 ? "0" + month: month;
        var date = d.getDate();
        var firstday = year + "-" + month + "-" + "01";
        var lastday = "";
        if (month == "01" || month == "03" || month == "05" || month == "07" || month == "08" || month == "10" || month == "12") {
            lastday = year + "-" + month + "-" + 31;
        } else if (month == "02") {
            if ((year % 4 == 0 && year % 100 != 0) || (year % 100 == 0 && year % 400 == 0)) {
                lastday = year + "-" + month + "-" + 29;
            } else {
                lastday = year + "-" + month + "-" + 28;
            };
        } else {
            lastday = year + "-" + month + "-" + 30;
        };
        var day = "";
        if (type == "s") {
            day = firstday;
        } else {
            day = lastday;
        };
        return day;
    };


    function getYear(type, dates) {
        var dd = new Date();
        var n = dates || 0;
        var year = dd.getFullYear() + Number(n);
        if (type == "s") {
            var day = year + "-01-01";
        };
        if (type == "e") {
            var day = year + "-12-31";
        };
        if (!type) {
            var day = year + "-01-01/" + year + "-12-31";
        };
        return day;
    };



    function filterDate($year,$month,$date,$type){
        if($type==1){
            $v="00:00:00";
        }else{
            $v="23:59:59";
        }
        return [$year,$month,$date].join('-')+' '+$v;
    }


})
