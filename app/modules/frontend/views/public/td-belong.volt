
{% for key,model in models %}
    {% if model['show']==1%}
        <td>
          {% if key=="staff_name" %}
          <a href="javascript:;" class="choseName" data-sub_account_id={{item.sub_account_id}} data-staff_name={{item.staff_name}}>
            {%endif%}

        <?php
        if($model['type']=='text'){
            echo $item->$key;
        }elseif($model['type']=='select' or $model['type']=='suggest'){
            echo isset($model['options'][$item->$key])?$model['options'][$item->$key]['text']:$item->$key;
        }elseif($model['type']=='time'){
                echo  date('Y-m-d H:i:s',$item->$key);
        }elseif($model['type']=='day'){
                      $value=$item->$key;
                      if(isset($value)&&trim($value)!='')
                          $value=  date('Y-m-d',$value);
        }
        else{
            echo $item->$key;
        }
        ?>

          {% if key=="staff_name" %}
          </a>
          {%endif%}

        </td>
    {% endif  %}
{% endfor %}