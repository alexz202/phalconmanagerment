
<!DOCTYPE html>
<html>
    <head>
   {%block navlabblock%}
    {%endblock%}

   {% include "public/script.volt"%}
     {%block extrascript%}

    {%endblock%}
        <title>{%block title%}首页{%endblock%}</title>
    </head>
    <body>


         {{ partial("public/header")}}
        <div class="container_ful">
        <div class="main_left">
            {{ partial("public/left-nav")}}
        </div>
        <div class="main_right">
            {%block content%}

            {%endblock%}
        </div>
        </div>

        <!-- {% include "public/footer.volt"%}-->
         {% include "public/script.volt"%}
             {%block extrascript%}

            {%endblock%}
    </body>
   {% include "public/script_boot.volt"%}
</html>
