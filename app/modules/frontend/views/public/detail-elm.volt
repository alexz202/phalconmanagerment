

     {%for key,model in models%}
           {% if model['ispk']==1 and model['ispk'] is defined%}
                  {{ hidden_field(key) }}
              {% endif %}

            {%if model['detail']==1%}
                <div class="form-group">
                    <label for="fieldCreateDate" class="col-sm-2 control-label">{{model['lable']|default(key)}}</label>
                    <div class="col-sm-10" style="margin:5px;">

                      <?php
                            if($model['type']=='text'){
                                echo "<span class='form-control'>";
                                echo  $this->tag->getValue($key);
                                echo "</span>";
                            }elseif($model['type']=='select'){
                                  echo "<span class='form-control'>";
                                  if(isset($model['class'])&&($model['class']=='prov'||$model['class']=='city')){
                                       echo $this->tag->getValue($key);
                                  }else{
                                  $v= $this->tag->getValue($key);
                                   echo  $value= isset($model['options'][$v])?$model['options'][$v]['text']:$v;
                                  }
                                  echo "</span>";
                            }elseif($model['type']=='checkbox' or $model['type']=='radio'){
                                   echo "<span class='form-control'>";
                                   $v= $this->tag->getValue($key);
                                   echo  $value= isset($model['options'][$v])?$model['options'][$v]['text']:$v;
                                   echo "</span>";

                              } elseif($model['type']=='textarea'){
                                 echo  $this->tag->textArea([$key,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "field$key"]);
                            }elseif($model['type']=='editor'){
                                  echo  $this->tag->textArea([$key,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "field$key"]);
                            }elseif($model['type']=='time'){
                                echo "<span class='form-control'>";
                                echo  date("Y-m-d H:i:s",$this->tag->getValue($key));
                                echo "</span>";
                            }elseif($model['type']=='number'){
                                  echo "<span class='form-control'>";
                                  echo  $this->tag->getValue($key);
                                  echo "</span>";
                             }
                            else{
                                 echo "<span class='form-control'>";
                                 echo  $this->tag->getValue($key);
                                 echo "</span>";
                            }
                       ?>
                    </div>
                </div>
            {%endif%}
    {%endfor%}


