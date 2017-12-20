{%extends "base.volt"%}

{%block extrascript%}
   {{javascript_include('js/access.js')}}
{%endblock%}
{%block content%}
    <div class="row">
        <nav>
            <ul class="pager">
                <li class="previous">{{ link_to("role", "返回") }}</li>

            </ul>
        </nav>
    </div>

    <div class="page-header">
        <h1>
               权限配置
        </h1>
            {{ link_to("action":"javascript:;","text":"数据等级","local":false,"data-url":"/role/modifyDataLevel/"~role_id,"class":"ajaxModify btn btn-default btn-sm") }}
            {{ link_to("action":"javascript:;","text":"授权访问","local":false,"data-url":"/role/authDataGroup/"~role_id,"class":"ajaxModify btn btn-default btn-sm") }}
    </div>

    {{ content() }}

    {{ form('role/accessSave/'~role_id, "method":"post", "autocomplete" : "off", "class" : "form-horizontal") }}


    {%for index,controller in resource_list%}
    <div class="form-group">
        <div class="roleControlDiv">{{key_list[index]|default(index)}} {%if index=='customer' or index=='order' or index=='customerfollow'%}<a href='javascript:;' class="columnScreenBtn" data-url="/role/screen/{{index}}/{{role_id}}"> 屏蔽字段配置 </a> {%endif%} <div class="checkAllRoleDiv">全选&nbsp;&nbsp;<input type='checkbox'  class="checkAllRole {{index}}_checkAll" data-key='{{index}}' {%if nocheck_list[index]==0%}checked{%endif%} ></div></div>

        <div class="col-sm-10" style="margin:2px 0px 0px 60px">
                {%for item in controller%}
                <span> <input class="{{index}}_box checkElmnt" type='checkbox' data-key={{index}} name='aclcheck[]' value={{item['id']}}  {%if item['selected']==1%} checked {%endif%}>{{item['remark']}} &nbsp;&nbsp; </span>
                {%endfor%}

        </div>
    </div>

    {%endfor%}





    {{ hidden_field("role_id") }}

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('更新', 'class': 'btn btn-default') }}
        </div>
    </div>

    </form>
{%endblock%}