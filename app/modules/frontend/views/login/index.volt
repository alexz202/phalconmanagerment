
<div class="div-login">
             <h1 style='margin-left:150px;'>
                泽稷人才后台系统
             </h1>
         {{ form("login/loginSubmit", "method":"post", "autocomplete" : "off", "class" : "form-horizontal") }}

         <div class="form-group" style='margin:25px;'>
             <label for="fieldController" class="col-sm-2 control-label">用户ID</label>
             <div class="col-sm-8">
                 {{ text_field("sub_account_id", "size" : 15, "class" : "form-control", "id" : "fieldSubAccountId") }}
             </div>
         </div>


         <div class="form-group" style='margin:25px;'>
             <label for="fieldController" class="col-sm-2 control-label">密码</label>
             <div class="col-sm-8">
                 {{ password_field("password", "size" : 15, "class" : "form-control", "id" : "fieldStaffName") }}
             </div>
         </div>


         <div class="form-group" style='margin:25px;'>
             <div class="col-sm-offset-2 col-sm-10">
                 {{ submit_button('登 录', 'class': 'btn btn-success') }}
             </div>
         </div>

         <div class="form-group" style='margin:25px;'>
             <div class="col-sm-offset-2 col-sm-8">
                   {{ content() }}
             </div>
         </div>

         </form>
</div>