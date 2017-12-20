{%extends "base.volt"%}
{%block content%}
<div class="page-header">
    <h1>资源配置</h1>
</div>

{{ content() }}

<div class="row">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>编号</th>
            <th>控制器</th>
            <th>行为</th>
            <th>备注</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>类型</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
        {% for resource in page.items %}
            <tr>
                <td>{{ resource.getId() }}</td>
            <td>{{ resource.getController() }}</td>
            <td>{{ resource.getAction() }}</td>
            <td>{{ resource.getRemark() }}</td>
            <td>{{ date('Y-m-d H:i:s',resource.getCreatetime()) }}</td>
            <td>{{ date('Y-m-d H:i:s',resource.getUpdatetime())}}</td>
            <td>
            {%set type=resource.getType()%}
                 {{typelist[type]}}
            </td>
                <td>
                    {{ link_to("resource/edit/"~resource.getId(), "编辑","class":"btn btn-default btn-sm") }}
                    {{ link_to("action":"javascript:;","text":"删除","local":false,"class":"ajaxDelete btn btn-default btn-sm","data-url":"/resource/delete/"~resource.getId()) }}
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
                <li>{{ link_to("resource/index","首页") }}</li>
                <li>{{ link_to("resource/index?page="~page.before, "上一页") }}</li>
                <li>{{ link_to("resource/index?page="~page.next, "下一页") }}</li>
                <li>{{ link_to("resource/index?page="~page.last, "最后") }}</li>
                <li><a href="javascript:;">  {{ page.current~"/"~page.total_pages }}</a></li>
            </ul>
        </nav>
    </div>


       <div class="col-sm-5">
            <nav>
                  <ul class="pagination">
                        <li>{{ link_to("resource/new", "创建") }}</li>
                   </ul>
            </nav>
        </div>
</div>
{%endblock%}