/**
 * Created by Administrator on 2017/9/18.
 */
$(function () {
    $('.btnCreateUpdate').click(function(){
        var validate=$(".form-edit").validate();
        //  console.log(validate.form());
        if(validate.form()==true){
            return true;
        }
    })
})