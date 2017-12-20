{%extends "base.volt"%}
{%block content%}
    <div class="page-header">
        <h1>排序</h1>
            {{ form("columns/sortList", "method":"get", "autocomplete" : "off", "class" : "form-inline") }}
                        {% include "public/search-elm.volt"%}
              {{ end_form() }}
    </div>


     {%if chooseController==1%}
        {%set url="/columns/sortList"%}
         {%if urlstr!=''%}
                {%set _url=url~'?'~urlstr%}
         {%else%}
                 {%set _url=url%}
         {%endif%}

        <div class="row">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="12%">键名</th>
                        <th width="12%">标题</th>
                        <th width="12%">排序号</th>
                        <th width="12%">操作</th>
                    </tr>
                </thead>
                <tbody>
                {% if page.items is defined %}
                {% for item in page.items %}
                    <tr>
                        <td> {{item.getKey()}} </td>
                        <td> {{item.getLable()}} </td>
                        <td> {{item.getSort()}} </td>
                        <td>    {{ link_to("action":"javascript:;","text":"↑","local":false,"class":"sortBtn btn btn-default btn-sm","data-url":"/columns/submitSort","data-type":1,"data-id":item.getId()) }}
                                {{ link_to("action":"javascript:;","text":"↓","local":false,"class":"sortBtn btn btn-default btn-sm","data-url":"/columns/submitSort","data-type":2,"data-id":item.getId()) }}
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
     {%else%}
           <span>请先选择。。。</span>

    {%endif%}

    </div>

{%endblock%}