/**
 * Created by zhualex on 16/3/7.
 */

$(function(){

    $('.ajaxGet').click(function(){
        var data= $(this).data();
        var _url=data.url;
        var title=data.title;
        $.ajax(
            {
                type:'get',
                url:_url,
                success:function(msg){
                     if(checkAuth(msg,0)==false){
                         return false;
                     }
                    layer.open({
                        type: 1,
                        title: title,
                        closeBtn:1,
                        shadeClose: false,
                        skin: 'layui-layer-rim',
                        content: msg,
                        area: ['820px', '620px'],
                        btn: ['关闭'],
                        yes:function(index,layero){
                            layer.close(index);
                            return false;
                        }
                    });
                    belongBtnFunc('.userbelongBtnlayer');
                    // var prov=$('.prov').data().v||'';
                    // var city=$('.city').data().v||'';
                    // citySelect('.form-edit',prov,city);
                }

            }
        )
    });



    $('.ajaxGetCustomer').click(function(){
        var data= $(this).data();
        var _url=data.url;
        var title=data.title;
        $.ajax(
            {
                type:'get',
                url:_url,
                success:function(msg){
                    if(checkAuth(msg,0)==false){
                        return false;
                    }
                        layer.open({
                            type: 1,
                            title: title,
                            closeBtn:1,
                            shadeClose: false,
                            skin: 'layui-layer-rim',
                            content: msg,
                            area: ['820px', '620px'],
                            btn: ['关闭'],
                            yes:function(index,layero){
                                layer.close(index);
                                return false;
                            }
                        });
                        belongBtnFunc('.userbelongBtnlayer');
                        var prov=$('.prov').data().v;
                        var city=$('.city').data().v;
                        citySelect('.form-edit',prov,city);
                    }

            }
        )
    });




    $('.ajaxCreateCustomer').click(function(){
           var data= $(this).data();
           var _url=data.url;
           var title=data.title;
           $.ajax(
               {
                   type:'get',
                   url:_url,
                   success:function(msg){
                       if(checkAuth(msg,0)==false){
                           return false;
                       }

                       layer.open({
                           type: 1,
                           title: title,
                           closeBtn:1,
                           shadeClose: false,
                           skin: 'layui-layer-rim',
                           content: msg,
                           area: ['820px', '620px'],
                           btn: ['提交','关闭'],
                           yes:function(index,layero){
                               var validate=$(".form-create").validate();
                               if(validate.form()==true){
                                   var form=$('.form-create').serialize();
                                   var url=$('.form-create').attr('action');
                                   $.ajax(
                                       {
                                           type: 'post',
                                           url: url,
                                           data: form,
                                           async: false,
                                           dataType: 'json',
                                           success: function (msg) {
                                               if(msg.code==1){
                                                   layer.msg('操作成功');
                                               }else{
                                                   layer.msg(msg.msg+",操作失败。");
                                               }
                                               window.location.reload();
                                           }
                                       });
                               }
                           },
                           btn2:function(index,layero){
                               layer.close(index);
                               return false;
                           }
                       });
                       belongBtnFunc('.userbelongBtnlayer');
                       var prov=$('.prov').data().v;
                       var city=$('.city').data().v;
                       citySelect('.form-create',prov,city);
                       // $('.btnCreateUpdate').click(function(){
                       //      var validate=$(".form-create").validate();
                       //     if(validate.form()==true){
                       //         var form=$('.form-create').serialize();
                       //         var url=$('.form-create').attr('action');
                       //         $.ajax(
                       //             {
                       //                 type: 'post',
                       //                 url: url,
                       //                 data: form,
                       //                 async: false,
                       //                 dataType: 'json',
                       //                 success: function (msg) {
                       //                     if(msg.code==1){
                       //                         layer.msg('操作成功');
                       //                     }else{
                       //                         layer.msg(msg.msg+",操作失败。");
                       //                     }
                       //                     window.location.reload();
                       //                 }
                       //             });
                       //     }
                       // });
                   }

               }
           )
    });



    $('.ajaxModifyCustomer').click(function(){
        var data= $(this).data();
        var _url=data.url;
        var title=data.title;
        $.ajax(
            {
                type:'get',
                url:_url,
                success:function(msg){
                    if(checkAuth(msg,0)==false){
                        return false;
                    }
                    layer.open({
                        type: 1,
                        title: title,
                        closeBtn:1,
                        shadeClose: false,
                        skin: 'layui-layer-rim',
                        content: msg,
                        area: ['820px', '620px'],
                        btn: ['提交','关闭'],
                        yes:function(index,layero){
                            var validate=$(".form-edit").validate();
                            //  console.log(validate.form());
                            if(validate.form()==true){
                                var form=$('.form-edit').serialize();
                                var url=$('.form-edit').attr('action');
                                $.ajax(
                                    {
                                        type: 'post',
                                        url: url,
                                        data: form,
                                        async:false,
                                        dataType: 'json',
                                        success: function (msg) {
                                            if(msg.code==1){
                                                layer.msg('操作成功');
                                            }else{
                                                layer.msg('操作失败');
                                            }
                                            window.location.reload();
                                        }
                                    });
                            }
                        },
                        btn2:function(index,layero){
                            layer.close(index);
                            return false;
                        }
                    });
                    belongBtnFunc('.userbelongBtnlayer');
                    var prov=$('.form-edit .prov').data().v;
                    var city=$('.form-edit .city').data().v;
                    citySelect('.form-edit',prov,city);

                    // $('.btnCreateUpdate').click(function(){
                    //     var validate=$(".form-edit").validate();
                    //     //  console.log(validate.form());
                    //     if(validate.form()==true){
                    //         var form=$('.form-edit').serialize();
                    //         var url=$('.form-edit').attr('action');
                    //         $.ajax(
                    //             {
                    //                 type: 'post',
                    //                 url: url,
                    //                 data: form,
                    //                 async:false,
                    //                 dataType: 'json',
                    //                 success: function (msg) {
                    //                     if(msg.code==1){
                    //                         layer.msg('操作成功');
                    //                     }else{
                    //                         layer.msg('操作失败');
                    //                     }
                    //                     window.location.reload();
                    //                 }
                    //             });
                    //     }
                    // });

                }

            }
        )
    });




    $('.ajaxCreate').click(function(){
        var data= $(this).data();
        var _url=data.url;
        var title=data.title;
        $.ajax(
            {
                type:'get',
                url:_url,
                success:function(msg){
                    if(checkAuth(msg,0)==false){
                        return false;
                    }

                    layer.open({
                        type: 1,
                        title: title,
                        closeBtn:1,
                        shadeClose: false,
                        skin: 'layui-layer-rim',
                        content: msg,
                        area: ['920px', '720px'],
                        btn: ['提交','关闭'],
                        yes:function(index,layero){
                            var validate=$(".form-create").validate();
                            if(validate.form()==true) {
                                var form = $('.form-create').serialize();
                                var url = $('.form-create').attr('action');
                                $.ajax(
                                    {
                                        type: 'post',
                                        url: url,
                                        data: form,
                                        async: false,
                                        dataType: 'json',
                                        success: function (msg) {
                                            if (msg.code == 1) {
                                                layer.msg('操作成功');
                                            } else {
                                                layer.msg(msg.msg+",操作失败。");
                                            }
                                            window.location.reload();
                                        }
                                    });
                            }
                        },
                        btn2:function(index,layero){
                            layer.close(index);
                            return false;
                        }
                    });
                    belongBtnFunc('.userbelongBtnlayer');

                    renderElmJs(1);
                }

            }
        )
    });


    $('.ajaxModify').click(function(){
        var data= $(this).data();
        var _url=data.url;
        var title=data.title;
        $.ajax(
            {
                type:'get',
                url:_url,
                success:function(msg){
                    if(checkAuth(msg,0)==false){
                        return false;
                    }
                    layer.open({
                        type: 1,
                        title: title,
                        closeBtn:1,
                        shadeClose: false,
                        skin: 'layui-layer-rim',
                        content: msg,
                        area: ['920px', '720px'],
                        btn: ['提交','关闭'],
                        yes:function (index,layero) {
                            var validate=$(".form-edit").validate();
                            if(validate.form()==true) {
                                var form = $('.form-edit').serialize();
                                var url = $('.form-edit').attr('action');
                                $.ajax(
                                    {
                                        type: 'post',
                                        url: url,
                                        data: form,
                                        async: false,
                                        dataType: 'json',
                                        success: function (msg) {
                                            if (msg.code == 1) {
                                                layer.msg('操作成功');
                                            } else {
                                                layer.msg('操作失败');
                                            }
                                            window.location.reload();
                                        }
                                    });
                            }
                        },
                        bnt2:function(index,layero){
                            layer.close(index);
                            return false;
                        }

                    });
                    belongBtnFunc('.userbelongBtnlayer');
                    //元素的事件
                    renderElmJs(0);
                }
            }
        )
    });

    $('.ajaxDelete').click(function(){
        if(confirm('确定要删除？')) {
            var url = $(this).data().url;
            $.ajax(
                {
                    type: 'get',
                    url: url,
                    // dataType:'json',
                    success: function (_msg) {
                        _msg=checkAuth(_msg,1);
                        if(_msg==false){
                            return false;
                        }

                        if (_msg.code == 1) {
                            layer.msg('操作成功');
                            window.location.reload();
                        }
                        else {
                            layer.msg('操作失败');
                        }
                    }
                }
            );
        }
    });

    //导出
    $('.exportBtn').click(function(){
        var data= $(this).data();
        var _url=data.url;
        var title="导出";
        var exporturl=data.exporturl;
        $.ajax(
            {
                type:'get',
                url:_url+"?link="+exporturl,
                success:function(msg){
                    if(checkAuth(msg,0)==false){
                        return false;
                    }
                    var ss= layer.open({
                        type: 1,
                        title: title,
                        closeBtn:1,
                        shadeClose: false,
                        skin: 'layui-layer-rim',
                        content: msg,
                        area: ['720px', '420px'],
                        btn: ['关闭'],
                        yes:function(index,layero){
                            layer.close(index);
                            return false;
                        }
                    });

                    CheckBox('checkAll','checkRev','exportColumn');

                    $('.btnMakeExport').click(function(){
                        // var url=$('#link').val();
                        var columns=[];
                        $('.exportColumn').each(function () {
                            if($(this).prop("checked")==true){
                                columns.push($(this).val());
                            }
                        });
                        if(columns.length==0){
                            layer.msg('请选择导出的字段');
                            return ;
                        }

                        if(exporturl.indexOf('?')==-1){
                            exporturl= exporturl+"?export=1&exCo="+columns.join(',');
                        }else{
                            exporturl=  exporturl+"&export=1&exCo="+columns.join(',');
                        }
                        window.location.href=exporturl;

                        layer.close(ss);
                    });

                }

            }
        )
    });

    //导入
    $('.importBtn').click(function(){
        var data= $(this).data();
        var _url=data.url;
        var title="导入";
        var importurl=data.importurl;
        $.ajax(
            {
                type:'get',
                url:_url+"?link="+importurl,
                success:function(msg){
                    if(checkAuth(msg,0)==false){
                        return false;
                    }

                    var ss= layer.open({
                        type: 1,
                        title: false,
                        closeBtn:1,
                        shadeClose: false,
                        skin: 'layui-layer-rim',
                        content: msg,
                        area: ['720px', '420px'],
                        btn: ['关闭'],
                        yes:function(index,layero){
                            layer.close(index);
                            return false;
                        }
                    });

                    CheckBox('checkAllImport','checkRevImport','importColumn');

                    //生成模板文件
                    $('.btnMakeImport').click(function(){
                        var url=$(this).data().url;
                        var columns=[];
                        $('.importColumn_').each(function () {
                            columns.push($(this).val());
                        });

                        $('.importColumn').each(function () {
                            if($(this).prop("checked")==true){
                                columns.push($(this).val());
                            }
                        });
                        if(url.indexOf('?')==-1){
                            url= url+"?import=1&exCo="+columns.join(',');
                        }else{
                            url=  url+"&import=1&exCo="+columns.join(',');
                        }
                        window.location.href=url;
                     //   layer.close(ss);
                    });

                    //导入文件
                    $('.btnImportByFile').click(function(){
                        var url=$(this).data().url;
                        var formData=new  FormData();
                        formData.append('file',$('#fileCsv')[0].files[0]);
                        $.ajax(
                            {
                                type:'post',
                                url:url,
                                data: formData,
                                processData: false,
                                contentType: false,
                              //  dataType:'json',
                                // enctype: 'multipart/form-data',
                                // async: false,
                                beforeSend:function(){
                                    console.log("正在进行，请稍候");
                                },
                                success:function(msg){
                                    msg=checkAuth(msg,1);
                                    if(msg==false){
                                        return false;
                                    }
                                    if(msg['code']==true){
                                        var data=msg['data'];
                                        var _liststr=data.list.join('');
                                        var liststr="<div style='max-height: 350px;overflow-y: auto;margin: 5px;'>"+_liststr+"</div>";
                                        var tagstr="<p>总数："+data.all_cnt+";新增:"+data.add_cnt+"更新:"+data.update_cnt+"<p>";
                                        layer.alert(tagstr+liststr);
                                        layer.close(ss);
                                    }else{
                                        layer.alert(msg['msg']);
                                        layer.close(ss);
                                    }
                                }
                            });
                    });

                }

            }
        )
    });


    //高级搜索
    $('.gaosiSearchBtn').click(function(){
        var data= $(this).data();
        var _url=data.url;
        var link=data.link;
        var title="高级搜索";
        var iframe_index = layer.open({
            type: 2,
            title: false,
            closeBtn: 1,
            content:_url,
            shadeClose: false,
            skin: 'layui-layer-rim',
            area: ['920px', '620px'],
           // btn: ['关闭'],
            success: function(layero, index){
                var choseName=  layer.getChildFrame('.btnGss', index);
                var btnSave=  layer.getChildFrame('.btnGssSave', index);
                // var pix=  layer.getChildFrame('.pix', index);
                var form =  layer.getChildFrame('.form_gs', index);
                // citySelect(form,'','');
                $(choseName).click(function () {
                    var formlist = $(form).serialize();
                    window.location.href=link+'?'+formlist;
                    layer.close(index);
                    return false;
                })
            }
        });
    });



    belongBtnFunc('.userbelongBtn');

    function belongBtnFunc(obj){
        //获取所有者
        $(obj).click(function() {
            var data = $(this).data();
            var _url = data.url;
            var title = "所有者";

            var obj=data.obj;
            var suggest='#'+data.suggest;

            var iframe_index = layer.open({
                type: 2,
                title: false,
                closeBtn: 1,
                content:"/user/allList",
                shadeClose: false,
                skin: 'layui-layer-rim',
                area: ['1024px', '620px'],
                btn: ['关闭'],

                success: function(layero, index){
                    var choseName=  layer.getChildFrame('.choseName', index);
                    $(choseName).click(function () {
                        var sub_account_id=$(this).data().sub_account_id;
                        var staff_name=$(this).data().staff_name;
                        // $(window.parent.document).find("#belongTo").val(sub_account_id);
                        $('#belongTo').val(sub_account_id);

                        $(obj).val(sub_account_id);
                        $(suggest).val(staff_name);
                        // $(obj+' option').each(function(){
                        //     if($(this).val()==sub_account_id){
                        //         $(this).attr({'selected':true});
                        //         return true;
                        //     }
                        //
                        // });

                        layer.close(index);
                    })
                }

            });

        });
    }



    //回收
    $('.recoverBtn').click(function() {
        var data = $(this).data();
        var url="/customer/recover";

        if(confirm("确定要回收？")) {
            var seed_id = data.seed_id;
            $.ajax(
                {
                    type: 'post',
                    url: url,
                    data: {'seed_id': seed_id},
                    //dataType: 'json',
                    success: function (msg) {
                        msg=checkAuth(msg,1);
                        if(msg==false){
                            return false;
                        }

                        if(msg.code==1){
                            layer.msg('操作成功');
                        }else{
                            layer.msg('操作失败');
                        }
                        window.location.reload();
                    }
                });
        }
    });

    $('.selectPageSize').change(function(){
        var pagersize=parseInt($(this).val());
        var url=$(this).data().url;
        url=url+"&pagersize="+pagersize;
        window.location.href=url;
    })



    //批量回收客户
    $('.mutilpleRecover').click(function(){
        if($('.checkElm').is(':checked')){
            if(confirm("确定要批量回收客户？")){
                var seed_ids=[];
                $('.checkElm').each(function(){
                    if($(this).prop('checked')==true){
                        seed_ids.push($(this).val());
                    }
                })
                $.ajax(
                    {
                        type: 'post',
                        url: '/customer/mutipleRecover',
                        data: {'seed_ids': seed_ids.join(',')},
                        //  dataType: 'json',
                        async:false,
                        success: function (_msg) {
                            _msg=checkAuth(_msg,1);
                            if(_msg==false){
                                return false;
                            }

                            if(_msg.code==1){
                                layer.alert(_msg.msg);
                            }else{
                                layer.alert('操作失败');
                            }
                            window.location.reload();
                        }
                    });
            }
        }else{
            layer.msg('请先选择客户');
        }
    });


    //批量修改所有者
    $('.settingAccountBtn').click(function(){
            if($('.checkElm').is(':checked')){
                var sub_account_id=$('#chosenSubAccountId').val();
                if($.trim(sub_account_id)==''){
                    layer.msg('请先选择所有者');
                }else{
                    var seed_ids=[];
                    $('.checkElm').each(function(){
                        if($(this).prop('checked')==true){
                            seed_ids.push($(this).val());
                        }
                    })
                    $.ajax(
                        {
                            type: 'post',
                            url: '/customer/settingAccount',
                            data: {'seed_ids': seed_ids.join(','),'sub_account_id':sub_account_id},
                          //  dataType: 'json',
                            async:false,
                            success: function (msg) {
                                msg=checkAuth(msg,1);
                                if(msg==false){
                                    return false;
                                }

                                if(msg.code==1){
                                    layer.msg('操作成功');
                                }else{
                                    layer.msg('操作失败');
                                }
                                window.location.reload();
                            }
                        });
                }
            }else{
                layer.msg('请先选择客户');
            }


    });

    // $('.delBtn').click(function(){
    //         if(confirm('确定要删除？')){
    //             var url=$(this).data().url;
    //                 window.location.href=url;
    //         }
    // })

    $('.activeBtn').click(function(){
        var data = $(this).data();
        var url="/customer/activeCustomer";

        if(confirm("确定要激活客户？")) {
            var seed_id = data.seed_id;
            $.ajax(
                {
                    type: 'post',
                    url: url,
                    data: {'seed_id': seed_id},
                  //  dataType: 'json',
                    success: function (msg) {
                        msg=checkAuth(msg,1);
                        if(msg==false){
                            return false;
                        }
                        if(msg.code==1){
                            layer.msg('操作成功');
                        }else{
                            layer.msg('操作失败');
                        }
                        window.location.reload();
                    }
                });
        }
    })

    $('.mutilpleUpdate').click(function(){
        var data= $(this).data();
        var _url=data.url;
        var mutipurl=data.mutipurl;
        var checked_ids=[];

        $('.checkElm').each(function(){
            if($(this).prop('checked')==true){
                checked_ids.push($(this).val());
            }
        });

        var title="批量更新";
        var iframe_index = layer.open({
            type: 2,
            title: false,
            closeBtn: 1,
            content:_url,
            shadeClose: false,
            skin: 'layui-layer-rim',
            area: ['56%', '520px'],
            btn: ['关闭'],

            success: function(layero, index){
                 var choseName=  layer.getChildFrame('.btn_mutiple_update', index);
                $(choseName).click(function(){
                    var key1=null;
                    var key= layer.getChildFrame('#selectSt', index);
                     key=$(key).val();
                    if(key=='sub_account_id')
                        key="sub_account_id_search";
                    else if(key=='province'){
                        key="field"+key;
                        key1="fieldcity";
                        var _key1=layer.getChildFrame('#'+key1, index);
                        var  value1=$(_key1).val();
                    }
                    else
                        key="field"+key;
                    var valueObj=layer.getChildFrame('#'+key, index);
                    var  value=$(valueObj).val();

                    var type=layer.getChildFrame('#selectType', index);
                    type=$(type).val();
                    var data={};
                    data={'type':type,'key':key,'value':value}
                    if(key1){
                        data["key1"]=key1;
                        data['value1']=value1;
                    }

                    if(type==1){
                        if(checked_ids.length==0){
                            layer.alert('请先勾选项');
                            return false;
                        }
                        data["ids"]=checked_ids.join(',');
                    }

                    if(confirm("确定要批量更新?")){
                        $.ajax(
                            {
                                type: 'post',
                                url: mutipurl,
                                data: data,
                                dataType: 'json',
                                success: function (msg) {
                                    if(msg.code==1){
                                        layer.msg('操作成功');
                                    }else{
                                        layer.msg('操作失败');
                                    }
                                    layer.close(index);
                                    window.location.reload();
                                }
                            });
                    }
                });
            }
        });
    });

    //操作
    $('.controlBtn').click(function(){
        var data= $(this).data();
        var _url=data.url;
        var link=data.link;
        var title="操作";
        var iframe_index = layer.open({
            type: 2,
            title: false,
            closeBtn: 1,
            content:_url,
            shadeClose: false,
            skin: 'layui-layer-rim',
            area: ['96%', '720px'],
            btn: ['关闭'],

            success: function(layero, index){
                var choseName=  layer.getChildFrame('.btnGss', index);
                var btnSave=  layer.getChildFrame('.btnGssSave', index);
                // var pix=  layer.getChildFrame('.pix', index);
                var form =  layer.getChildFrame('.form_gs', index);
                // citySelect(form,'','');
                $(choseName).click(function () {
                    var formlist = $(form).serialize();
                    window.location.href=link+'?'+formlist;
                    layer.close(index);
                    return false;
                })
            }
        });
    });


    $('.btnControl').click(function () {
       var seed= $(this).data().seed;
       console.log(seed);
       $('#'+seed+"_control").show();
       $(this).remove();
    })


    $('.sortBtn').click(function(){
        var data = $(this).data();
        var url=data.url;
        var id=data.id;
        var type=data.type;
        if(confirm("确定要变更顺序？")) {
            $.ajax(
                {
                    type: 'post',
                    url: url,
                    data: {'id': id,'type':type},
                    dataType: 'json',
                    success: function (msg) {
                        if(msg.code==1){
                            layer.msg('操作成功');
                        }else{
                            layer.msg('操作失败');
                        }
                        window.location.reload();
                    }
                });
        }
    })


    //屏蔽字段
    $('.columnScreenBtn').click(function(){
        var data= $(this).data();
        var _url=data.url;
        var link=data.link;
        var title="屏蔽字段";
        var iframe_index = layer.open({
            type: 2,
            title: false,
            closeBtn: 1,
            content:_url,
            shadeClose: false,
            skin: 'layui-layer-rim',
            area: ['96%', '720px'],
            btn: ['关闭'],

            success: function(layero, index){
                var choseName=  layer.getChildFrame('.btnGss', index);
                var btnSave=  layer.getChildFrame('.btnGssSave', index);
                // var pix=  layer.getChildFrame('.pix', index);
                var form =  layer.getChildFrame('.form_gs', index);
                // citySelect(form,'','');
                $(choseName).click(function () {
                    var formlist = $(form).serialize();
                    window.location.href=link+'?'+formlist;
                    layer.close(index);
                    return false;
                })
            }
        });
    });



    CheckBox('checkAllElm','','checkElm');

    function CheckBox(btnCheckAll,btnCheckRev,classExportColumn){
        //全选
        $('.'+btnCheckAll).click(function(){
            if($(this).prop('checked')==true){
                $('.'+classExportColumn).prop("checked",true);
            }else{
                $('.'+classExportColumn).prop("checked",false);
            }

        });


        if(btnCheckRev!==''){
            //反选
            $('.'+btnCheckRev).click(function(){
                $('.'+classExportColumn).each(function () {
                    if($(this).prop('checked')==true){
                        $(this).prop("checked",false);
                    }else{
                        $(this).prop("checked",true);
                    }
                });
                checkChk();
            });

        }
        $('.'+classExportColumn).click(function(){
            checkChk(btnCheckAll,classExportColumn);
        });

    }

    function checkChk(btnCheckAll,classExportColumn){
        var size= $('.'+classExportColumn).size();
        var chk=0;
        $('.'+classExportColumn).each(function () {
            if($(this).prop('checked')==true){
                chk++;
            }
        });

        if(chk==size){
            $('.'+btnCheckAll).prop("checked",true);
        }else{
            $('.'+btnCheckAll).prop("checked",false);
        }
    }

    function citySelect(obj,prov,city){
        $(obj).citySelect({
            nodata:"none",
            required:false,
            prov:prov,
            city:city
        });

    }



    function checkAuth(msg,returenJson){
        if(msg=='NoAuth'){
            layer.msg('无权限访问！');
            return false;
        }

        if(returenJson)
            return eval("("+msg+")");
        else
            return msg;
    }


    $('.hideLeftBtn').click(function(){
        if($('#tree').is(":hidden")){
            $('#tree').show();
            $('.main_left').css({"width":"11%"});
            $('.main_right').css({"width":"88%"});
            $(this).html('<<--');
        }else{
            $('#tree').hide();
            $('.main_left').css({"width":"3%"});
            $('.main_right').css({"width":"96%"});
            $(this).html('-->>');
        }
    });

    // var List='{$league_info}';
    // List=eval('('+List+')');
    // var gsm_league_id=new Array();
    // $(List).each(function(i,n){
    //     gsm_league_id[i]=new Array(n.id,n.name,' ');
    // })
    //
    // $("#Fsugget").suggest(gsm_league_id,{hot_list:gsm_league_id,dataContainer:'#gsm_league_id',onSelect:function(){}, attachObject:'#gsm_league_id_div'});

    function renderElmJs(iscreate){
        for(var obj in app.arguments){
            var create=app.arguments[obj]['create'];
            var edit=app.arguments[obj]['edit'];
            var type=app.arguments[obj]['type'];
            if(iscreate==1){
                if(create==1){
                    filterType(type,obj);
                }
            }else{
                if(edit==1){
                    filterType(type,obj);
                }
            }
        }
    }

    function filterType(type,obj){
        var type=app.arguments[obj]['type'];
        if(type=="time" || type=="datetime"){
            $('#field'+obj).datetimepicker({
                autoclose: true,
                format: 'yyyy-mm-dd hh:ii:ss'
            });
        }else if(type=='day'){
            $(function(){
                $('#field'+obj).datetimepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    language:"zh-CN",
                    startView: 2,
                    minView: 2,
                });
            });
        }
        else if(type=='editor'){
            var editor = KindEditor.create('textarea[name="'+obj+'"]',{
                allowFileManager : true,
                 afterBlur: function () {
                    console.log('after blur');
                    this.sync(); }
            });

        }else if(type=='image'){
            var token=app.arguments[obj]['token']||'';
            var foloder=app.arguments[obj]['foloder']||'';
            var remote=app.toRemote;
            var makeThumb=app.arguments[obj]['makeThumb']||0;
            console.log(remote);
            console.log(makeThumb);
            $('#field_'+obj).uploadify({
                'swf'      : '/js/uploadify/uploadify.swf',
                'uploader' : '/js/uploadify/uploadify.php',
                'auto':true,
                'fileTypeExts':'*.gif; *.jpg; *.png;*.pdf;*.txt;*.xlsx;*.doc;*.csv;',
                'formData':{"foloder":foloder,'token':token,'type':'img','remote':remote,'makeThumb':makeThumb},
                'onUploadSuccess' : function(file, data, response) {
                    var  msg=eval("("+data+")");
                    if(msg.code==1){
                        $('#h_'+obj).val(msg.data.fileUri);
                        // $('#ext').val( msg.data.ext);
                        // $('#fileSize').val( msg.data.filesize);
                        if(remote==1)
                            $('#f_'+obj).html("<img src='"+app.remote_server+msg.data.fileUri+"' width='80'/>");
                        else
                            $('#f_'+obj).html("<img src='"+msg.data.fileUri+"' width='80'/>");
                    }else{
                        $('#f_'+obj).html('上传失败！');
                    }
                }
                ,'onSelectError':function () {
                    alert('文件格式不支持');
                    return false;
                }
            });
        }else if(type=='file'){
            var token=app.arguments[obj]['token']||'';
            var foloder=app.arguments[obj]['foloder']||'';
            var remote=app.toRemote;
            $('#field_'+obj).uploadify({
                'swf'      : '/js/uploadify/uploadify.swf',
                'uploader' : '/js/uploadify/uploadify.php',
                'auto':true,
                'fileTypeExts':'*.gif; *.jpg; *.png;*.pdf;*.txt;*.xlsx;*.doc;*.csv;',
                'formData':{"foloder":foloder,'token':token,'type':'img','remote':remote},
                'onUploadSuccess' : function(file, data, response) {
                    var  msg=eval("("+data+")");
                    if(msg.code==1){
                        $('#h_'+obj).val(msg.data.fileUri);
                        $('#f_'+obj).html('已上传:'+msg.data.fileName);
                    }else{
                        $('#f_'+obj).html('上传失败！');
                    }
                }
                ,'onSelectError':function () {
                    alert('文件格式不支持');
                    return false;
                }
            });

        }
    }


})
