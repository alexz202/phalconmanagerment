{%extends "base.volt"%}

{%block content%}
    <div class="page-header">
        <h1>角色管理</h1>

                  <div class="row">
                                   {% include "public/search-elm-jh-co.volt"%}
                                           {{ form("role/index", "method":"get", "autocomplete" : "off", "class" : "form-inline form-common-search") }}
                                      <div class="col-md-8">
                                            {% include "public/search-elm-jh.volt"%}
                                       </div>
                                    {{ end_form() }}
                          </div>
    </div>

    {%set url="/role/index"%}
     {%if urlstr!=''%}
            {%set _url=url~'?'~urlstr%}
     {%else%}
             {%set _url=url%}
         {%endif%}
    <div class="row">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    {% include "public/th" with['url':_url,'urlstr':urlstr]%}
                    <th width=8%>操作</th>
                </tr>
            </thead>
            <tbody>
            {% if page.items is defined %}
            {% for item in page.items %}
                <tr>
                       {% include "public/td" with['item':item]%}
                    <td>
                      {{ link_to("action":"javascript:;","text":"修改","local":false,"data-url":"/role/edit/"~item.getRoleId(),"class":"ajaxModify btn btn-default btn-sm") }}
                   {{ link_to("role/access/"~item.getRoleId(), "权限",'class':"btn btn-default btn-sm") }}
                    {{ link_to("action":"javascript:;","text":"删除","local":false,"class":"ajaxDelete btn btn-default btn-sm","data-url":"/role/delete/"~item.getRoleId()) }}
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
        <div class="col-sm-6">
            <nav>
                  <ul class="pagination">
                    {% include "public/pagination.volt"%}
                   </ul>
            </nav>
        </div>
            <div class="col-sm-5">
                <nav>
                      <ul class="pagination">
                            <li>{{ link_to("action":"javascript:;","text":"创建","local":false,"data-url":"/role/new","class":"ajaxCreate") }}</li>
                       </ul>
                </nav>
            </div>
    </div>

{%endblock%}