{%extends "base.volt"%}
{%block content%}
    <div class="page-header">
        <h1>角色管理</h1>
    </div>

    {{ content() }}

    <div class="row">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                     <th>角色ID</th>
                      <th>角色英文名（*唯一）</th>
                           <th>角色名</th>
                           <th>备注</th>
                           <th>创建时间</th>
                           <th>修改时间</th>
                                <th width=12%></th>
                </tr>
            </thead>
            <tbody>
            {% if page.items is defined %}
            {% for role in page.items %}
                <tr>
                    <td>{{ role.getRoleId() }}</td>
                    <td>{{ role.getRole() }}</td>
                    <td>{{ role.getRoleName() }}</td>
                    <td>{{ role.getRemark() }}</td>
                    <td>{{ role.getCreateDate() }}</td>
                    <td>{{ role.getUpdateDate() }}</td>
                    <td>
                        {{ link_to("role/edit/"~role.getRoleId(), "编辑",'class':"btn btn-default btn-sm") }}
                        {{ link_to("role/access/"~role.getRoleId(), "权限",'class':"btn btn-default btn-sm") }}
                        {{ link_to("action":"javascript:;","text":"删除","local":false,"class":"delBtn btn btn-default btn-sm","data-url":"/role/delete/"~role.getRoleId()) }}
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
                    <li>{{ link_to("role/index", "首页") }}</li>
                    <li>{{ link_to("role/index?page="~page.before, "上一页") }}</li>
                    <li>{{ link_to("role/index?page="~page.next, "下一页") }}</li>
                    <li>{{ link_to("role/index?page="~page.last, "最后") }}</li>
                        <li><a href="javascript:;">  {{ page.current~"/"~page.total_pages }}</a></li>
                </ul>
            </nav>
        </div>



           <div class="col-sm-5">
                <nav>
                      <ul class="pagination">
                            <li>{{ link_to("role/new", "创建") }}</li>
                       </ul>
                </nav>
            </div>
    </div>
{%endblock%}




