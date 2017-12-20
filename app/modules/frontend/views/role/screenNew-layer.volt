{%extends "base-layer.volt"%}
{%block content%}
<p></p>
{{ form("role/screenCreate", "method":"post", "autocomplete" : "off", "class" : "form-horizontal form-create") }}

     {%set isCreate=1%}
          {% include "public/edit-elm" with{'isCreate':isCreate}%}

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
           <a href="javascript:;" class="btn btn-default btnCreateUpdate">提交</a>
       <!-- {{ submit_button('提交', 'class': 'btn btn-default btnCreateUpdate') }}-->
    </div>
</div>

</form>
{%endblock%}