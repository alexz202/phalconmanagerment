
{% for key,model in models %}
      {%if model['ispk']==1%}
       <td> <input type="checkbox" value="<?php echo $item->$key?>" class="checkElm"/></td>
       {%endif%}
    {% if model['show']==1%}
        <td>
        <?php
        if($model['type']=='text'){
            $value= $item->$key;
        }elseif($model['type']=='select' or $model['type']=='suggest'){
            $value= isset($model['options'][$item->$key])?$model['options'][$item->$key]['text']:$item->$key;
        }elseif($model['type']=='time'){
                $value=$item->$key;
                if(isset($value)&&trim($value)!='')
                    $value=  date('Y-m-d',$value)."<br/>".date('H:i:s',$value);
        }elseif($model['type']=='datetime'){
                if(trim($item->$key)!='1900-01-01 00:00:00')
                    $value=  $item->$key;
        }elseif($model['type']=='day'){
             $value=$item->$key;
             if(isset($value)&&trim($value)!='')
                 $value=  date('Y-m-d',$value);
        }elseif($model['type']=='image'){
               $value=$item->$key;
               if(!empty($value)){
                    if($remote==1)
                        echo "<img src='{$remote_server}{$value}' width='80'/>";
                    else
                        echo "<img src='{$value}' width='80'/>";
               }
                continue;
        }elseif($model['type']=='file'){
                   $value=$item->$key;
             if(!empty($value)){
                    if($remote==1)
                       echo $remote_server.$value;
                    else
                       echo $value;
             }
             continue;
        }
        else{
            $value= $item->$key;
        }

        if(isset($model['gas'])&& intval($model['gas'])==1&&intval($item->user_id)!=$user_id){
                if(strlen($value)>7){
                    echo substr($value,0,3)."****".substr($value,-4);
                }
                elseif(strlen($value)>0){
                    echo substr($value,0,1)."****";
                }else
                    echo $value;
        }else{
               echo $value;
        }

        ?>
        </td>
    {% endif  %}
{% endfor %}