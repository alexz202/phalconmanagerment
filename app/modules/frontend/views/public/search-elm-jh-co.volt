
 {{javascript_include('js/search.js')}}

<div class="col-md-2">
    <select id='selectSt' class="form-control">
        {%for key,model in models%}
             {%if model['search']==1 and key!='city'%}
                {%if searchKey==key%}
                    <option value="{{key}}" selected> {{model['lable']}}</option>
                {%else%}
                    <option value="{{key}}"> {{model['lable']}}</option>
                {%endif%}
            {%endif%}
        {%endfor%}
    </select>
</div>
