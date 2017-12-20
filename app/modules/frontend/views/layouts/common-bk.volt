<!DOCTYPE html>
<html>
    <head>
         {% include "public/script.volt"%}

       <title>{%block title%}crm首页{%endblock%}</title>
    </head>
    <body>
    <!--{% include "public/header.volt"%}-->
         {{ partial("public/header")}}

 <!--content render start -->
<div class="container_ful">
<div class="main_left">
    {{ partial("public/left-nav")}}
</div>
<div class="main_right">
 {{ content() }}
</div>
</div>

 <!--content render end
     {% include "public/footer.volt"%}
      {{ partial("public/footer")}}-->
    </body>

</html>