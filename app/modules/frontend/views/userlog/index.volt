{%extends "base.volt"%}
{%block content%}
<div class="row">
    <nav>
        <ul class="pager">
        </ul>
    </nav>
</div>

<div class="page-header">
    <h1>用户日志</h1>
            {{ form("userlog/index", "method":"Get", "autocomplete" : "off", "class" : "form-inline") }}
                        {% include "public/search-elm.volt"%}
              {{ end_form() }}
</div>

{{ content() }}

<div class="row">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                  {% include "public/th.volt"%}
            </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
        {% for item in page.items %}
            <tr>
                {% include "public/td" with['item':item]%}
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
    <div class="col-sm-11">
        <nav>
           <ul class="pagination">
                               {%set url="userlog/index"%}
                               {%if urlstr!=''%}
                                    {%set _url=url~'?'~urlstr%}
                                  <li>{{ link_to(_url, "首页") }}</li>
                                  <li>{{ link_to(_url~"&page="~page.before, "上一页") }}</li>
                                  <li>{{ link_to(_url~"&page="~page.next, "下一页") }}</li>
                                  <li>{{ link_to(_url~"&page="~page.last, "最后") }}</li>
                              {%else%}
                                  <li>{{ link_to(url, "首页") }}</li>
                                  <li>{{ link_to(url~"?page="~page.before, "上一页") }}</li>
                                  <li>{{ link_to(url~"?page="~page.next, "下一页") }}</li>
                                  <li>{{ link_to(url~"?page="~page.last, "最后") }}</li>
                              {%endif%}
                                  <li><a href="javascript:;">  {{ page.current~"/"~page.total_pages }}</a></li>
                          </ul>
        </nav>
    </div>
</div>
{%endblock%}