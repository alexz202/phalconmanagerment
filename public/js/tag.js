/**
 * Created by zhualex on 16/3/7.
 */

$(function(){
    initsearch();
    function initsearch(){
        $('.tagtype').each(function(){
            if($(this).data().check==1){
                var key=$(this).data().key;
                var value=$(this).data().v;
                $('#tag_'+key).show();

                $('#tag_'+key).find('li').each(function(){
                    if($(this).children('a').data().v==value){
                        $(this).addClass('tag-hover');
                    }
                })
            }
        })
    }

    //普通搜索聚合
    $('.tagtype').click(function(){
        var key=$(this).data().key;
        $('.tag_value_ul').hide();
        $('#tag_'+key).show();
    })
})
