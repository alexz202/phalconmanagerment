
  <script>
    var treeId={{treeId}};
      var nodeName='{{nodeName|default('index')}}';

  </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="/favicon.ico" />
   <!--    {{ stylesheet_link('css/webtools.css') }}-->
        <!--   {{ stylesheet_link('js/bootstrap/treeview/bootstrap-treeview.min.css') }}-->
               <!--   {{ stylesheet_link('js/jquery-ui-1.12.1/jquery-ui.min.css') }}-->
        {{ stylesheet_link('css/common.css') }}
         {{stylesheet_link('bootstrap/css/bootstrap.css') }}
        {{ stylesheet_link('css/fonts/iconfont.css') }}
          {{ stylesheet_link('bootstrap/datetimepicker/css/bootstrap-datetimepicker.min.css') }}
        {{ stylesheet_link('css/suggest.css') }}

            {{ stylesheet_link('js/kindeditor/themes/default/default.css') }}
            {{ stylesheet_link('js/kindeditor/plugins/code/prettify.css') }}

           {{ stylesheet_link('js/uploadify/uploadify.css') }}

            {{javascript_include('js/jquery/jquery-2.1.4.min.js')}}
           {{javascript_include('js/jquery-ui-1.12.1/jquery-ui.min.js')}}
           {{javascript_include('bootstrap/js/bootstrap.min.js')}}
           {{javascript_include('bootstrap/treeview/bootstrap-treeview.min.js')}}
           {{javascript_include('bootstrap/datetimepicker/js/bootstrap-datetimepicker.min.js')}}
           {{javascript_include('bootstrap/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')}}
           {{javascript_include('js/leftTreeView.js')}}
            {{javascript_include('js/layer/layer.js')}}
             {{javascript_include('js/laytpl.js')}}
            {{javascript_include('js/cityselect/jquery.cityselect.js')}}

             {{javascript_include('js/uploadify/jquery.uploadify.js')}}

            {{javascript_include('js/jquery/validate/jquery.validate.min.js')}}
              {{javascript_include('js/jquery/validate/localization/messages_zh.js')}}
                {{javascript_include('js/j.suggest.js')}}

               {{javascript_include('js/kindeditor/kindeditor-all.js')}}
                     {{javascript_include('js/kindeditor/lang/zh-CN.js')}}
                   {{javascript_include('js/kindeditor/plugins/code/prettify.js')}}


        {% if navlab is defined and navlab =='usersales' %}
            {{ stylesheet_link('css/usersales.css') }}
         {%endif%}
