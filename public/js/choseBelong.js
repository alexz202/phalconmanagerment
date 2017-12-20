/**
 * Created by zhualex on 16/3/7.
 */

$(function(){
    $.ajax(
        {
            type: 'get',
            url: "/dept/treeList",
            success: function (msg) {
                $('#deptTree').treeview({
                    data:msg,
                    showCheckbox: false,
                    showBorder:false,
                    onNodeSelected: function (event, data) {
                        if(data.href!='')
                            window.location.href=data.href;
                    }

                })

            }
        });

    //
    // $('.choseName').click(function(){
    //    // console.log($(this).data().sub_account_id);
    //     var sub_account_id=$(this).data().sub_account_id;
    //     $(window.parent.document).find("#belongTo").val(sub_account_id);
    //     var index=$('#iframeV').val();
    //     layer.close(index);
    // });



})
