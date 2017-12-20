/**
 * Created by Administrator on 2017/8/23.
 */

$(function(){
    $('.btnCreateUpdate').click(function(){
        var form=$('.form-edit').serialize();
        var url=$('.form-edit').attr('action');
        console.log(url);
        $.ajax(
            {
                type: 'post',
                url: url,
                data: form,
                async:false,
                dataType: 'json',
                success: function (msg) {
                    console.log(msg);
                    if(msg.code==1){
                        layer.msg('操作成功');
                    }else{
                        layer.msg('操作失败');
                    }
                    window.location.reload();
                }
            });
    });

});