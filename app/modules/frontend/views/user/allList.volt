{%extends "base-iframe.volt"%}
{%block extrascript%}
     {{javascript_include('js/choseBelong.js')}}
{%endblock%}
{%block content%}

    <div class="col-md-3 allUser_l">
        <div id="deptTree"></div>
    </div>

        <div class="col-md-9 allUser_r">
            {% include "user/allList-e.volt"%}
        </div>
{%endblock%}

