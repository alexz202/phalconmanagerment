
      {%for key,model in models%}
            {%if model['show']==1%}
                <th {%if model['width'] is defined%} width={{model['width']}} {%endif%}>{{model['lable']|default(key)}}</th>
            {%endif%}
        {%endfor%}