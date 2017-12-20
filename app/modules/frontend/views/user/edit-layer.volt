{%extends "base-layer.volt"%}
{%block content%}
    <p></p>
    {{ form("user/save", "method":"post", "autocomplete" : "off", "class" : "form-horizontal form-edit") }}
           {%set isCreate=0%}
           {% include "public/edit-elm" with{'isCreate':isCreate}%}

             <div class="form-group" style="display:none;" id='change_sales_level_div'>
                               <label for="fieldCreateDate" class="col-sm-2 control-label">
                                  销售等级
                               </label>
                               <div class="col-sm-offset-2 col-sm-10">
                                  {{select_static('sales_level','class':'form-control',sales_level_list)}}
                               </div>
                   </div>

         <div class="form-group">
             <div class="col-sm-offset-2 col-sm-10">
                  <!--  <a href="javascript:;" class="btn btn-default btnCreateUpdate">提交</a>-->
             </div>
         </div>
    </form>
          <script>
               $(function(){
                  var change_state=$("input[name='is_duty_sales']:checked").val();
                   if(parseInt(change_state)==1){
                               $('#change_sales_level_div').show();
                   }

                   $('.radiois_duty_sales').click(function(){
                           var change_state=$("input[name='is_duty_sales']:checked").val();
                           console.log(change_state);
                           if(parseInt(change_state)==1){
                                       $('#change_sales_level_div').show();
                           }else{
                                   $('#change_sales_level_div').hide();
                           }
                   });
               })

           </script>
{%endblock%}