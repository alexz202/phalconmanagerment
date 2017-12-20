<!DOCTYPE html>
<html>
    <head>
        {{ stylesheet_link('css/common.css') }}
         {{stylesheet_link('bootstrap/css/bootstrap.css') }}
        {{ stylesheet_link('css/fonts/iconfont.css') }}

         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         {{javascript_include('js/jquery/jquery-2.1.4.min.js')}}
        <title>crm首页</title>
    </head>
    <body>
 <!--content render start -->
<div class="login_backgroud">
 {{ content() }}
</div>


 <!--content render end
     {% include "public/footer.volt"%}
      {{ partial("public/footer")}}-->
    </body>
</html>