
    {%for key,model in models%}
         {%if model['search']==1%}
             <div class="form-group">
                 <label class="" for="{{"field"~key}}">{{model['lable']}}</label>
                 <?php
                        if($model['type']=='text'){

                        echo  $this->tag->textField([$key, "size" => 30, "class" => "form-control", "id" => "field".$key]);

                        }elseif($model['type']=='select'){
                                $select_list=array();
                                $select_list['']='所有';
                                foreach($model['options'] as $k=>$v){
                                    $select_list[$k]=$v['text'];
                                }
                               echo  $this->tag->selectStatic([$key,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "field$key"],$select_list);
                        }elseif($model['type']=='checkbox'){
                                foreach($model['options'] as $k=>$v){
                                    echo   $this->tag->checkField(array($key,"value"=>$k ,"class" => "check$key"))  ;
                                    echo $v['text'];
                                }
                            } elseif($model['type']=='radio'){
                              foreach($model['options'] as $k=>$v){
                                   echo $this->tag->radioField(array($key,"value"=>$k ,"class" => "radio$key"));
                                   echo $v['text'];
                               }
                          } elseif($model['type']=='textarea'){

                             echo  $this->tag->textArea([$key,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "field$key"]);

                        }elseif($model['type']=='editor'){

                              echo  $this->tag->textArea([$key,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "field$key"]);

                        }elseif($model['type']=='time'){

                            echo  $this->tag->textField([$key, "size" => 30, "class" => "form-control", "id" => "field".$key]);

                        }elseif($model['type']=='number'){
                            echo  $this->tag->numericField([$key, "size" => 30, "class" => "form-control", "id" => "field".$key]);
                         }
                        else{
                            echo  $this->tag->textField([$key, "size" => 30, "class" => "form-control", "id" => "field".$key]);
                        }
                    ?>
                 </div>
           {%endif%}
         {%endfor%}

      <button type="submit" class="btn btn-default">搜索</button>
