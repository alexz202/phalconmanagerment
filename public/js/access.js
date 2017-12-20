/**
 * Created by Administrator on 2017/9/11.
 */
$(function () {

    //全选
    $('.checkAllRole').click(function () {
        var key= $(this).data().key;
        var checkElement=key+'_box';

        if($(this).prop('checked')==true){
            $('.'+checkElement).prop("checked",true);
        }else{
            $('.'+checkElement).prop("checked",false);
        }
        var that=$(this);
        _CheckBox(that,checkElement);
    });


    //单个选择判断
    $('.checkElmnt').click(function () {
        var key= $(this).data().key;
        var checkElement=key+'_box';
        var checkAll=$('.'+key+'_checkAll');
        _checkChk(checkAll,checkElement);
    })



    function _CheckBox(btnCheckAll,classExportColumn){

        $('.'+classExportColumn).click(function(){
            _checkChk(btnCheckAll,classExportColumn);
        });

    }

    function _checkChk(btnCheckAll,classExportColumn){
        var size= $('.'+classExportColumn).size();
        var chk=0;
        $('.'+classExportColumn).each(function () {
            if($(this).prop('checked')==true){
                chk++;
            }
        });

        if(chk==size){
            $(btnCheckAll).prop("checked",true);
        }else{
            $(btnCheckAll).prop("checked",false);
        }
    }

})