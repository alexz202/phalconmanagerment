{%extends "base.volt"%}
{%block content%}
<div class="row">
    <nav>
        <ul class="pager">
            <li class="previous">{{ link_to("resource", "Go Back") }}</li>
        </ul>
    </nav>
</div>

<div class="page-header">
    <h1>
        创建资源
    </h1>
</div>

{{ content() }}

{{ form("resource/create", "method":"post", "autocomplete" : "off", "class" : "form-horizontal") }}

<div class="form-group">
    <label for="fieldController" class="col-sm-2 control-label">控制器</label>
    <div class="col-sm-10">
        {{ text_field("controller", "size" : 30, "class" : "form-control", "id" : "fieldController") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldAction" class="col-sm-2 control-label">行为</label>
    <div class="col-sm-10">
        {{ text_field("action", "size" : 30, "class" : "form-control", "id" : "fieldAction") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldRemark" class="col-sm-2 control-label">备注</label>
    <div class="col-sm-10">
        {{ text_field("remark", "size" : 30, "class" : "form-control", "id" : "fieldRemark") }}
    </div>
</div>


<div class="form-group">
    <label for="fieldType" class="col-sm-2 control-label">类型</label>
    <div class="col-sm-10">
     {{select_static('type','class':'form-control',typelist)}}
    </div>
</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ submit_button('创建', 'class': 'btn btn-default') }}
    </div>
</div>

</form>
{%endblock%}