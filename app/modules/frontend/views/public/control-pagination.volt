<div class="suggest-div" style="float:right;margin-right:20px;">
         <div class="div-kmove">
                  <select name="pagesize" class="selectPageSize" data-url="{{_url_nopagersize~"&page="~page.current}}">
                          {%for i in [5,10,15,20,25,30,40,50]%}
                           <option value="{{i}}" {%if i==pagersize%} selected{%endif%}>{{i}}</option>
                          {%endfor%}
                        </select> 条/页
         </div>
         <div class="div-kmove">
               <a href="javascript:;">  {{"共有记录:"~page.total_items~"条&nbsp;当前页:"~ page.current~"/"~page.total_pages}}</a>
         </div>
 </div>