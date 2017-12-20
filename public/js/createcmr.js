/**
 * Created by Administrator on 2017/8/23.
 */

$(function(){
    init();

    function init() {
        var prov=$('.prov').data().prov||' ';
        var city=$('.city').data().city||' ';
        citySelect('.form_gs',prov,city);
    }




    function citySelect(obj,prov,city){
        console.log(prov,city);
        $(obj).citySelect({
           // nodata:"none",
            required:false,
            prov:prov,
            city:city
        });

    }

});