
$(function(){
    // $.ajax(
    //     {
    //         type: 'post',
    //         url: "/usersales/treeData",
    //         data:{'id':1},
    //         dataType:"json",
    //         success: function (msg) {
    //             console.log(msg);
    //             $('#treeData').treeview({
    //                 data:msg.data,
    //                 showCheckbox: false,
    //                 showBorder:false,
    //                 onNodeSelected: function (event, data) {
    //
    //                 }
    //
    //             })
    //
    //         }
    //     });


    // $('#treeData').treeview({
    //                     data:treeData,
    //                     showCheckbox: false,
    //                     showBorder:true,
    //                     onNodeSelected: function (event, data) {
    //     }
    // });


    $(".boxx-body").scroll(function() {
       var moveV= $(this).scrollTop();
        $(".boxx-body-3").scrollTop(moveV);
    });

    // $(".boxx-body-3").scroll(function() {
    //     var moveV= $(this).scrollTop();
    //     $(".boxx-body").scrollTop(moveV);
    // });


    $(".treeScl").click(function(){
        var data=$(this).data();
        var user_id=data.userId;
        var level=data.level;
        var start=0;
        var diff_level=0;
        var diff_v=0;

        if(data.status==1){
            //展开
            $('.tr_tree_l').each(function(){
                if(start==1&& $(this).data().level<=level){
                    return false;
                }else if(start==1){
                    //一级级处理
                    // if($(this).data().jd==1){
                    //     if($(this).find('.treeScl').data().status==1){
                    //         diff_level=$(this).find('.treeScl').data().level;
                    //         diff_v=1;
                    //         console.log(diff_level);
                    //     }else{
                    //         diff_v=0;
                    //         diff_level=0;
                    //     }
                    //     //如果是节点 判断状态
                    //     // $(this).find('.treeScl').html("<span class=\"glyphicon glyphicon-minus-sign\" aria-hidden=\"true\"></span>");
                    //     $('.rshow_'+$(this).data().userId).show();
                    //     $(this).show();
                    // }else{
                    //     if(diff_v==0){
                    //         //如果不是节点的话 直接SHOW
                    //         $('.rshow_'+$(this).data().userId).show();
                    //         $(this).show();
                    //     }
                    // }

                    //展开所有叶子

                    if($(this).data().jd==1){
                        //如果是节点 判断状态
                        if($(this).find('.treeScl').data().status==1){
                            $(this).find('.treeScl').html("<span class=\"glyphicon glyphicon-minus-sign\" aria-hidden=\"true\"></span>");
                        }
                        $('.rshow_'+$(this).data().userId).show();
                        $(this).show();
                    }else{
                            //如果不是节点的话 直接SHOW
                            $('.rshow_'+$(this).data().userId).show();
                            $(this).show();
                    }
                }

                if($(this).data().userId==user_id){
                    start=1;
                }
            });


            $(this).html("<span class=\"glyphicon glyphicon-minus-sign\" aria-hidden=\"true\"></span>");
            data.status=0;
        }else{
            //收缩
            $('.tr_tree_l').each(function(){
                if(start==1&& $(this).data().level<=level){
                    return false;
                }else if(start==1){
                    $('.rshow_'+$(this).data().userId).hide();
                    $(this).hide();
                }

                if($(this).data().userId==user_id){
                    start=1;
                }
            });
            $(this).html("<span class=\"glyphicon glyphicon-plus-sign\" aria-hidden=\"true\"></span>");
            data.status=1;
        }


    })

})
