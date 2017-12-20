 {{javascript_include('js/operate.js')}}
<div class="row">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" {%if operate_tag=='customerfollow'%} class="active" {%endif%}><a href="#" aria-controls="home" role="tab" data-toggle="tab" id="operate-customerfollow" data-url='{{"/customerfollow/operate/"~customer_id}}'>客户跟进</a></li>
      <li role="presentation" {%if operate_tag=='customerremark'%} class="active" {%endif%}><a href="#" aria-controls="home" role="tab" data-toggle="tab" id="operate-customerremark" data-url='{{"/customerremark/operate/"~customer_id}}'>客户备注</a></li>
      {%if customer_kind==2%}
             <li role="presentation"{%if operate_tag=='order'%} class="active" {%endif%}><a href="#" aria-controls="profile" role="tab" data-toggle="tab" id="operate-order" data-url='{{"/order/operate/"~customer_id}}'>订单管理</a></li>
       {%endif%}
    </ul>
</div>