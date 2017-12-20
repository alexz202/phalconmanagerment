{%extends "base-iframe.volt"%}
{%block content%}
<div class="page-header">
    <h1> 屏蔽字段管理</h1>
</div>


{%set url="/customerfollow/index"%}
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
                         {{ link_to("action":"javascript:;","text":"删除","local":false,"class":"ajaxDelete btn btn-default btn-sm","data-url":"/role/screenDelete/"~item.getId()) }}
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
                       <li>{{ link_to("action":"javascript:;","text":"创建","local":false,"data-url":"/role/screenNew/"~_model~'/'~role_id,"class":"ajaxCreate") }}</li>
                   </ul>
            </nav>
        </div>
</div>

{%endblock%}



