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
      var value_s=  $('.radiosearch:checked').val();
        var value_gs=  $('.radiogassearch:checked').val();

        if(value_s==1){
            $('#co-search-div').show();
        }
        if(value_gs==1){
            $('#co-gsearch-div').show();
        }
    }


    $('.radiosearch').click(function () {
        var value=$(this).val();
        if(value==1){
                $('#co-search-div').show();
        }else{
            $('#co-search-div').hide();
        }
    });


    $('.radiogassearch').click(function () {
        var value=$(this).val();
        if(value==1){
            $('#co-gsearch-div').show();
        }else{
            $('#co-gsearch-div').hide();
        }
    });



});