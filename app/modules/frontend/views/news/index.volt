{%extends "base.volt"%}
{%block content%}
{%set url="/news/index"%}
 {%if urlstr!=''%}
        {%set _url=url~'?'~urlstr%}
 {%else%}
         {%set _url=url%}
 {%endif%}
 {%set script_arguments=models%}

<div class="page-header">
    <h1>管理</h1>
        {{ form("news/index", "method":"get", "autocomplete" : "off", "class" : "form-inline") }}
                     {% include "public/search-elm-jh.volt"%}
          {{ end_form() }}

</div>

{{ content() }}

<div class="row">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                {% include "public/th.volt"%}
                <th width=12%></th>
            </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
        {% for item in page.items %}
            <tr>
                   {% include "public/td" with['item':item]%}
                <td>
                    {{ link_to("action":"javascript:;","text":"修改","local":false,"data-url":"/news/edit/"~item.getId(),"class":"ajaxModify btn btn-default btn-sm") }}
                    {{ link_to("action":"javascript:;","text":"删除","local":false,"class":"ajaxDelete btn btn-default btn-sm","data-url":"/news/delete/"~item.getId()) }}

                </td>
            </tr>
        {% endfor %}
        {% endif %}
        </tbody>
    </table>
</div>


<div class="row">
    <div class="col-sm-1">
        <p class="pagination" style="padding: 6px 12px;">
        </p>
    </div>
  <div class="col-sm-5">
        <nav>
              <ul class="pagination">
                    {% include "public/pagination.volt"%}
               </ul>
        </nav>
    </div>

       <div class="col-sm-5">
            <nav>
                  <ul class="pagination">
                        <li>{{ link_to("action":"javascript:;","text":"创建","local":false,"data-url":"/news/new","class":"ajaxCreate") }}</li>
                   </ul>
            </nav>
        </div>

</div>

{%endblock%}
