{%extends "base.volt"%}
{%block content%}
<div class="page-header">
    <h1>员工账号</h1>
      <div class="row">
                                    {% include "public/search-elm-jh-co.volt"%}
                                            {{ form("user/index", "method":"get", "autocomplete" : "off", "class" : "form-inline form-common-search") }}
                                       <div class="col-md-8">
                                                   {% include "public/search-elm-jh.volt"%}
                                        </div>
                                     {{ end_form() }}
                           </div>
</div>

  {% include "public/tag" with{'url':'/user/index'}%}

{%set url="/user/index"%}
 {%if urlstr!=''%}
        {%set _url=url~'?'~urlstr%}
 {%else%}
         {%set _url=url%}
     {%endif%}


<div class="row">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
               {% include "public/th.volt"%}
                    <th width=8%></th>
            </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
        {% for item in page.items %}
            <tr>
             {% include "public/td" with['item':item]%}
             <td>
                {{ link_to("action":"javascript:;","text":"查看","local":false,"data-url":"/user/detail/"~item.getUserId(),"class":"ajaxGet btn btn-default btn-sm") }}
                {{ link_to("action":"javascript:;","text":"修改","local":false,"data-url":"/user/edit/"~item.getUserId(),"class":"ajaxModify btn btn-default btn-sm") }}
                {{ link_to("action":"javascript:;","text":"删除","local":false,"class":"ajaxDelete btn btn-default btn-sm","data-url":"/user/delete/"~item.getUserId()) }}

              </td>
            </tr>
        {% endfor %}
        {% endif %}
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-sm-1">
        <p class="pagination" style="line-height: 1.42857;padding: 6px 12px;">
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
                                <li>{{ link_to("action":"javascript:;","text":"创建","local":false,"data-url":"/user/new","class":"ajaxCreate") }}</li>
                           </ul>
                    </nav>
                </div>
</div>

{%endblock%}



