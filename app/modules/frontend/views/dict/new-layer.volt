{%extends "base-layer.volt"%}
{%block content%}
    <p></p>
    {{ form("dict/create", "method":"post", "autocomplete" : "off", "class" : "form-horizontal form-create") }}

           {%set isCreate=1%}
                {% include "public/edit-elm" with{'isCreate':isCreate}%}


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">

        </div>
    </div>

    </form>

{%endblock%}