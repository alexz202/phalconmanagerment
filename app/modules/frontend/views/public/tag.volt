 {{javascript_include('js/tag.js')}}
<div class="row">
    <ul class='list-inline list-unstyled' id="tag_type_ul" >
        {%for key,model in models%}
                {%if model['tag']==1 and  model['options'] is defined%}
                     {%if searchKey is defined and searchKey==key %}
                        <li><a href="javascript:;" class="tagtype tag-hover" data-key="{{key}}" data-check=1 data-v="{{tag.getValue(searchKey)}}"> [{{model['lable']}}]</a></li>
                      {%else%}
                        <li><a href="javascript:;" class="tagtype" data-key="{{key}}" data-check=0> [{{model['lable']}}]</a></li>
                     {%endif%}
                 {%endif%}
        {%endfor%}
    </ul>

        {%for key,model in models%}
            {%if model['tag']==1 and model['options'] is defined%}
                 <ul class='list-inline list-unstyled tag_value_ul' id="tag_{{key}}" style="display:none">
                     {%for k,item in model['options'] %}
                           <li><a href='{{url}}?{{key}}={{k}}' data-v="{{k}}">{{item['text']}}</a></li>
                     {%endfor%}
                 </ul>
             {%endif%}
        {%endfor%}
</div>

