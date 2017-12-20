/**
 * Created by Administrator on 2017/8/23.
 */

$(function(){

    // $('.form_gs').citySelect({
    //     // nodata:"none",
    //     required:false,
    //     prov:prov,
    //     city:city
    // });
    init();
    function init() {
        if($('.prov').length>0){
            var prov=$('.prov').data().prov;
            var city=$('.city').data().city;
            citySelect('.form_gs',prov,city);
        }
    }

    $("#selectDefined").change(function () {
        var id=$(this).val();
        var s_url=$(this).data().surl;
        window.location.href=s_url+"?gsid="+id;
    })

    $('.btnGssSave').click(function () {
        var gsid=parseInt($('.gsid').val());
        var value=$('.form_gs').serialize();
        if(gsid>0){
            //存在的话更新
            var url=$(this).data().updateUrl;
            updateGs(url,gsid,value);
        }else{
            //添加新的
            var ss= $('#layerSave').html();
            var data={};
            laytpl(ss).render(data, function(html){
                var index=layer.open({
                    type: 1,
                    title: false,
                    skin: 'layui-layer-rim', //加上边框
                    area: ['420px', '240px'], //宽高
                    content:html
                });

                $('.btnGsSaveAct').click(function () {
                    var url=$(this).data().url;
                    var key=$('.key').val();
                    var pix=$('.pix').val();
                    if($.trim(key)==''){
                         layer.msg('名称不能为空');
                    }else{
                        setGsKeyValue(url,pix,value,key,index);
                    }
                })

                return false;
            });

        }
    });

    $('.btnGssDel').click(function () {
        var gsid=parseInt($('.gsid').val());
        if(gsid>0){
            if(confirm('确定要删除此查询？')){
                //存在的话更新
                var url=$(this).data().updateUrl;
                delGs(url,gsid);
            }
        }else{
            layer.msg('请先保存！！');
        }
    });


    function citySelect(obj,prov,city){
        console.log(prov,city);
        $(obj).citySelect({
           // nodata:"none",
            required:false,
            prov:prov,
            city:city
        });

    }

    function setGsKeyValue(url,pix,value,key,index){
        $.ajax(
            {
                type: 'post',
                url: url,
                data: {'pix': pix,'value':value,'key':key},
                dataType: 'json',
                success: function (msg) {
                    if(msg.code==1){
                        layer.msg('操作成功');
                    }else{
                        layer.msg('操作失败');
                    }
                    layer.close(index);
                    var id=msg.data.id;
                   var s_url= $("#selectDefined").data().surl;
                    window.location.href=s_url+"?gsid="+id;
                }
            });
    }

    function updateGs(url,gsid,value){
        $.ajax(
            {
                type: 'post',
                url: url,
                data: {'gsid': gsid,'value':value},
                dataType: 'json',
                success: function (msg) {
                    console.log(msg);
                    if(msg.code==1){
                        layer.msg('操作成功');
                    }else{
                        layer.msg('操作失败');
                    }
                }
            });
    }

    function delGs(url,gsid){
        $.ajax(
            {
                type: 'post',
                url: url,
                data: {'gsid': gsid},
                dataType: 'json',
                success: function (msg) {
                    console.log(msg);
                    if(msg.code==1){
                        layer.msg('操作成功');
                        var s_url= $("#selectDefined").data().surl;
                        window.location.href=s_url;
                    }else{
                        layer.msg('操作失败');
                    }
                }
            });
    }


    $('.gselectTimeSuit').change(function () {
        console.log('suit');

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
        //
        // console.log(start_time);
        // console.log(end_time);
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

});