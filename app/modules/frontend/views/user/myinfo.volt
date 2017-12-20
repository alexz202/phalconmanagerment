{%extends "base.volt"%}
{%block extrascript%}
      {{javascript_include('js/myinfo.js')}}
{%endblock%}

{%block content%}
    <div class="row">
        <nav>

        </nav>
    </div>

    <div class="page-header">
        <h1>
               我的信息
        </h1>
    </div>

    {{ content() }}




    {{ form("user/save", "method":"post", "autocomplete" : "off", "class" : "form-horizontal form-edit") }}
       {%set isCreate=0%}
             {% include "public/edit-elm" with{'isCreate':isCreate}%}


         <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                         <a href="javascript:;" class="btn btn-default btnCreateUpdate">提交</a>
                     <!-- {{ submit_button('提交', 'class': 'btn btn-default btnCreateUpdate') }}-->
                  </div>
              </div>

    </form>
 {%endblock%}