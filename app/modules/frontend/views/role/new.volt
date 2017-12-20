{%extends "base.volt"%}
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
               创建角色
        </h1>
    </div>

    {{ content() }}

    {{ form("role/create", "method":"post", "autocomplete" : "off", "class" : "form-horizontal") }}

    <div class="form-group">
        <label for="fieldController" class="col-sm-2 control-label">角色英文名（唯一）</label>
        <div class="col-sm-10">
            {{ text_field("role", "size" : 30, "class" : "form-control", "id" : "fieldRole") }}
        </div>
    </div>

    <div class="form-group">
        <label for="fieldController" class="col-sm-2 control-label">角色名</label>
        <div class="col-sm-10">
            {{ text_field("role_name", "size" : 30, "class" : "form-control", "id" : "fieldRoleName") }}
        </div>
    </div>


    <div class="form-group">
        <label for="fieldRemark" class="col-sm-2 control-label">备注</label>
        <div class="col-sm-10">
            {{ text_field("remark", "size" : 30, "class" : "form-control", "id" : "fieldRemark") }}
        </div>
    </div>




    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('创建', 'class': 'btn btn-default') }}
        </div>
    </div>

    </form>
{%endblock%}