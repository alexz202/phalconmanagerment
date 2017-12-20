

<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                {% include "public/th-belong.volt"%}
            </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
        {% for item in page.items %}
            <tr class="checkElmId">
                   {% include "public/td-belong" with['item':item]%}
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
                     {%set url="user/allList"%}
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
                </ul>
        </nav>

    </div>
</div>



