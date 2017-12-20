
{%- macro pagination(url,urlstr,page,me) %}
      <ul class="pagination">
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
{%- endmacro %}