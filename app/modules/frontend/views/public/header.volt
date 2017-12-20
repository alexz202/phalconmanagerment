<nav class="navbar nav-header" role="navigation" style="height:80px;border-radius:0px;margin:0px 0px 30px 0px; border-bottom: 2px solid #e0e3e8;">
 <div class="container-fluid">
      <div class='log' style='font-size:18px;margin:5px 10px 15px 20px;float:left;'>
             <img src="/img/logo4.png" width="190" style="margin-top:3px;"/>
      </div>
        <div class='text-right' style="margin:45px 10px 0 0;float:right;">
                           {%if isLogin==1%}
                               {{nickname}},欢迎您的登录！&nbsp;&nbsp;
                                <a href='/login/loginout'>退出</a>
                           {%else%}
                                <a href='/login/index'>登陆</a>
                            {%endif%}
                        </div>
 </div>
</nav>
