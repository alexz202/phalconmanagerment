
      <th  width="4%"><input type="checkbox" class="checkAllElm"/>全选</th>
      {%for key,model in models%}
            {%if model['show']==1%}
                <th {%if model['width'] is defined%} width={{model['width']}} {%else%} width='5%' {%endif%}>
                    {%if model['orderby']==1%}
                    <?php
                     $v='orderby_'.$key;
                     $vv=0;
                     if(isset($$v)){
                        $vv= $$v;
                        if($vv==intval(1))
                             $v=2;
                        else{
                            $v=1;
                        }
                     }else{
                         $v=1;
                         $vv=0;
                     }
                    ?>
                         {%if urlstr!==''%}
                            {%set url_order=url~'&orderby='~v~'-'~key%}
                         {%else%}
                            {%set url_order=url~'?orderby='~v~'-'~key%}
                         {%endif%}
                        {{ link_to(url_order, model['lable']|default(key)) }}
                        {%if vv==1%}
                            ↑
                        {% elseif vv==2 %}
                            ↓
                        {%else%}
                            *
                        {%endif%}
                    {%else%}
                        {{model['lable']|default(key)}}
                    {%endif%}

                </th>
            {%endif%}
        {%endfor%}