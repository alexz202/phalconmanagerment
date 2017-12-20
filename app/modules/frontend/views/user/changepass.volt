{%extends "base.volt"%}
{%block extrascript%}
     {{javascript_include('js/changepass.js')}}
{%endblock%}
{%block content%}
<div class="row">
    <nav>
        <ul class="pager">
            <li class="previous">{{ link_to("/user/index", "返回") }}</li>
        </ul>
    </nav>
</div>

<div class="page-header">
    <h1>
           修改员工
    </h1>
</div>

{{ content() }}

{{ form("user/changepassSave", "method":"post", "autocomplete" : "off", "class" : "form-horizontal form-edit") }}
     {%set isCreate=0%}
           {% include "public/edit-elm" with{'isCreate':isCreate}%}
  <div class="form-group">
             <div class="col-sm-offset-2 col-sm-10">
                {{ submit_button('提交', 'class': 'btn btn-default btnCreateUpdate') }}
             </div>
         </div>

</form>
{%endblock%}