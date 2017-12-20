
    {%for key,model in models%}
         {%if model['search']==1%}
            {{model['lable']}}
             <div class="form-group">
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
                                 $value=$this->tag->getValue($key);
                                 if($model['searchOptions']['type']=='between'){
                                        if(isset($value)&& $value!=null){

                                        $value=explode(',',$value);
                                             if(!isset($value[0]))
                                                $value[0]='';
                                              if(!isset($value[1]))
                                                 $value[1]='';
                                        }else{
                                            $value=['',''];
                                        }


                                        echo  "<div class=\"col-sm-5\">".$this->tag->textField(['name'=>$key.'[]', "size" => 30, "class" => "form-control", "id" => "startfield".$key,"value"=>$value[0],"placeholder"=>"开始"])."</div>";
                                        echo   "<div class=\"col-sm-5\">".$this->tag->textField(['name'=>$key.'[]', "size" => 30, "class" => "form-control", "id" => "field".$key,"value"=>$value[1],"placeholder"=>"至"]). "</div>";
                                 }else{
                                      if(isset($value))
                                          $value=date('Y-m-d H:i:s',$this->tag->getValue($key));
                                      else
                                          $value='';
                                      echo  $this->tag->textField(['name'=>$key,'value'=>$value, "size" => 30, "class" => "form-control", "id" => "field".$key]);
                                 }
                        }elseif($model['type']=='number'){
                            echo  $this->tag->numericField([$key, "size" => 30, "class" => "form-control", "id" => "field".$key]);
                         }
                        else{
                            echo  $this->tag->textField([$key, "size" => 30, "class" => "form-control", "id" => "field".$key]);
                        }
                    ?>


                      {%if model['type']=='datetime' or model['type']=='time'%}

                                    {%if model['searchOptions']['type']=='between'%}
                                           <script>
                                                  $(function(){
                                                       $('#startfield{{key}}').datetimepicker({
                                                             autoclose: true,
                                                                format: 'yyyy-mm-dd hh:ii:ss'

                                                      });


                                                       $('#field{{key}}').datetimepicker({
                                                              autoclose: true,
                                                              format: 'yyyy-mm-dd hh:ii:ss'

                                                        });
                                                  });
                                            </script>
                                    {%else%}
                                        <script>
                                        $(function(){
                                             $('#field{{key}}').datetimepicker({
                                                   autoclose: true,
                                                      format: 'yyyy-mm-dd hh:ii:ss'
                                             });
                                        });

                                        </script>
                                    {%endif%}
                        {%endif%}

                        {%if model['class'] is defined and model['type']=='select' and  model['class']=='prov'%}
                                    <script>
                                    $(function(){
                                         $('.form-common-search').citySelect({
                                                    nodata:"none",
                                                    required:false,
                                                    prov:$('.prov').data().v,
                                                    city:$('.city').data().v,
                                                });
                                    });

                                    </script>
                        {%endif%}
                 </div>
           {%endif%}
         {%endfor%}

      <button type="submit" class="btn btn-default">搜索</button>
