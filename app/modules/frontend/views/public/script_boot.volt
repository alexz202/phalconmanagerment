<script>
      var app = {};
      app.toRemote={{remote}};
      app.remote_server="{{remote_server}}";
   {% if script_arguments is defined %}
      app.arguments ={{ script_arguments|json_encode }};
    {% endif %}
</script>
  {{javascript_include('js/common.js')}}