                <div class="form-group cscommon" id="dcs_{{key}}" style="display:none;">
                 <?php
                        if($model['type']=='text'){
                        echo  $this->tag->textField([$key, "size" => 30, "class" => "form-control", "id" => "field".$key]);
                        }elseif($model['type']=='select'){
                                $select_list=array();
                                 if(isset($model['class'])&&($model['class']=='prov')){
                                      //   echo "<select name='$key' class='{$model['class']}'></select>";
                                         $prov= $this->tag->getValue($key);
                                      echo "<div class='col-sm-6' style='padding-left:0px;'>" .$this->tag->selectStatic([$key,"cols" => 50,"rows" => 4,"class" => "form-control ".$model['class'], "id" => "field$key",'data-v'=>$prov],$select_list)."</div>";
                                            $citykey='city';
                                           $city= $this->tag->getValue($citykey);
                                      echo "<div class='col-sm-6'>" . $this->tag->selectStatic([$citykey,"cols" => 50,"rows" => 4,"class" => "form-control ".$citykey, "id" => "field$citykey",'data-v'=>$city],$select_list)."</div>";
                                 }else{
                                       if(isset($model['options'])&&count($model['options'])>0){
                                           foreach($model['options'] as $k=>$v){
                                                 $select_list[$k]=$v['text'];
                                           }
                                       }
                                       echo  $this->tag->selectStatic([$key,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "field$key"],$select_list);
                                 }
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

                        }elseif($model['type']=='time' or $model['type']=='day'){
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

                                    $optionstr="";
                                    $optionlist=array(
                                        '0'=>'选择',
                                        '1'=>'今天',
                                        '2'=>'昨天',
                                        '3'=>'明天',
                                        '4'=>'本周',
                                         '5'=>'上周',
                                          '6'=>'下周',
                                           '7'=>'本月',
                                           '8'=>'上月',
                                            '9'=>'下月',
                                             '10'=>'今年',
                                              '11'=>'去年',
                                    );
                                    foreach($optionlist as $k=>$v){
                                         $optionstr.="<option value=$k>$v</option>";
                                    }
                                    echo  "<div class=\"col-sm-2\"><select id='selectTimeSuit' class='form-control selectTimeSuit' data-key='field-s$key'>".$optionstr."</select></div>";
                                    echo  "<div class=\"col-sm-4\">".$this->tag->textField(['name'=>$key.'[]', "size" => 30, "class" => "form-control", "id" => "startfield-s".$key,"value"=>$value[0],"placeholder"=>"开始"])."</div>";
                                    echo   "<div class=\"col-sm-4\">".$this->tag->textField(['name'=>$key.'[]', "size" => 30, "class" => "form-control", "id" => "field-s".$key,"value"=>$value[1],"placeholder"=>"至"]). "</div>";
                             }else{
                                  if(isset($value))
                                      $value=date('Y-m-d H:i:s',$this->tag->getValue($key));
                                  else
                                      $value='';
                                  echo  $this->tag->textField(['name'=>$key,'value'=>$value, "size" => 30, "class" => "form-control", "id" => "field-s".$key]);
                             }
                        }elseif($model['type']=='number'){
                            echo  $this->tag->numericField([$key, "size" => 30, "class" => "form-control", "id" => "field".$key]);
                         }elseif($model['type']=='suggest'){
                            $value=$this->tag->getValue($key);
                            if(isset($value))
                                $keyvalue=$model['options'][$value]['text'];
                            else
                                $keyvalue='';
                              echo   "<input id=\"{$key}_search\" name=\"{$key}\" type=\"hidden\"/>";
                              echo  "<input id=\"{$key}_Suggest\" type=\"text\" class=\"form-control\" value=\"{$keyvalue}\"/>";
                              echo   "<div id=\"{$key}_search_div\"  class=\"ac_results\"></div>";
                         }
                        else{
                            echo  $this->tag->textField([$key, "size" => 30, "class" => "form-control", "id" => "field".$key]);
                        }
                    ?>

                      {%if model['type']=='datetime' or model['type']=='time' or model['type']=='day'%}

                                    {%if model['searchOptions']['type']=='between'%}
                                           <script>
                                                  $(function(){
                                                       $('#startfield-s{{key}}').datetimepicker({
                                                             autoclose: true,
                                                                format: 'yyyy-mm-dd 00:00:00',
                                                                language:"zh-CN",
                                                               	startView: 2,
                                                               		minView: 2,

                                                      });


                                                       $('#field-s{{key}}').datetimepicker({
                                                              autoclose: true,
                                                              format: 'yyyy-mm-dd 23:59:59',
                                                                language:"zh-CN",
                                                             	startView: 2,
                                                             		minView: 2,
                                                        });
                                                  });
                                            </script>
                                    {%else%}
                                        <script>
                                        $(function(){
                                             $('#field-s{{key}}').datetimepicker({
                                                   autoclose: true,
                                                      format: 'yyyy-mm-dd',
                                                      language:"zh-CN",
                                                        startView: 2,
                                                        minView: 2,
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

                        {%if model['type']=='suggest'%}
                            <script>
                                $(function(){
                                             var List='{{selectSubAccountIdOptionsJson}}';
                                                          List=eval('('+List+')');
                                                          var sub_account_id=new Array();
                                                          $(List).each(function(i,n){
                                                              sub_account_id[i]=new Array(n.id,n.name,' ');
                                                          });

                                            $("#{{key}}_Suggest").suggest(sub_account_id,{hot_list:sub_account_id,dataContainer:'#{{key}}_search',onSelect:function(){}, attachObject:'#{{key}}_search_div'});
                                 });

                            </script>

                        {%endif%}

                 </div>