/**
 * Created by zhualex on 16/2/8.
 */
$(function(){
   $('#login_btn_submit').click(function(){
   //提交登陆：
        var account_id=$('#account_id').val();
        var password=$('#password').val();
        var img_verity=$('#img_verity').val();
        if ($.trim(account_id).length<1 ){
            alert('账号名、密码不能为空');
            return false;
        }else if($.trim(password).length<1){
            alert('密码不能为空');
            return false;
       }
       else if($.trim(img_verity).length<1){
            alert('验证码不能为空');
            return false;
       }
        else{
            $('#login_form').submit();
            return true;
        }
   })
})