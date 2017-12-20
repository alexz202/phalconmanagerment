                     <li>{{ link_to(_url, "首页") }}</li>
                       <li>{{ link_to(_url~"&page="~page.before, "上一页") }}</li>
                       <li>{{ link_to(_url~"&page="~page.next, "下一页") }}</li>
                       <li>{{ link_to(_url~"&page="~page.last, "最后") }}</li>
                        <li><a href="javascript:;">  {{"共有记录:"~page.total_items~"条&nbsp;当前页:"~ page.current~"/"~page.total_pages}}</a></li>