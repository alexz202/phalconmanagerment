
    {%set index=0%}
    {%for key,model in models%}
         {%if model['search']==1 and key!='city'%}
                 {% include "public/form-elm-models.volt"%}
           {%endif%}
         {%endfor%}
            <button type="submit" class="btn btn-default">搜索</button>
