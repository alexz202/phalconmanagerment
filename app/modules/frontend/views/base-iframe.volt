<!DOCTYPE html>
<html>
    <head>
          {% include "public/script.volt"%}
                  {%block extrascript%}

                  {%endblock%}
                  <title>{%block title%}crm首页{%endblock%}</title>
    </head>
    <body>

        <div class="container_ful" style="width:90%;margin:auto auto;">
                {%block content%}

                {%endblock%}
        </div>

    </body>

</html>