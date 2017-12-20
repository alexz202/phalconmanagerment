/**
 * Created by zhualex on 16/3/7.
 */

$(function(){


    $('#operate-order').click(function () {
        var url=$(this).data().url;
        window.location.href=url;
    });

    $('#operate-customerfollow').click(function () {
        var url=$(this).data().url;
        window.location.href=url;
    });
    $('#operate-customerremark').click(function () {
        var url=$(this).data().url;
        window.location.href=url;
    });

})
