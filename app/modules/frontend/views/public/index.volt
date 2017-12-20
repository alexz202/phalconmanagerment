<div class="row">
    <nav>
        <ul class="pager">
            <li class="next">{{ link_to("dept/new", "Create ") }}</li>
        </ul>
    </nav>
</div>

<div class="page-header">
    <h1>部门管理</h1>
</div>

{{ content() }}

<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
            {% include "public/th.volt"%}
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
        {% for item in page.items %}
            <tr>
              {% include "public/td.volt" with ['item':item]%}
                <td>{{ link_to("dept/edit/"~dept.getDeptId(), "Edit") }}</td>
                <td>{{ link_to("dept/delete/"~dept.getDeptId(), "Delete") }}</td>
            </tr>
        {% endfor %}
        {% endif %}
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-sm-1">
        <p class="pagination" style="line-height: 1.42857;padding: 6px 12px;">
            {{ page.current~"/"~page.total_pages }}
        </p>
    </div>
    <div class="col-sm-11">
        <nav>
            <ul class="pagination">
                <li>{{ link_to("dept/search", "First") }}</li>
                <li>{{ link_to("dept/search?page="~page.before, "Previous") }}</li>
                <li>{{ link_to("dept/search?page="~page.next, "Next") }}</li>
                <li>{{ link_to("dept/search?page="~page.last, "Last") }}</li>
            </ul>
        </nav>
    </div>
</div>
