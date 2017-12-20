
    {%for key in columns%}
         <div class="form-group">
                   <label for="fieldCreateDate" class="col-sm-2 control-label">{{model[key]['lable']}}</label>
                   <?php

                          $name='gs-'.$key;
                           if(!isset($$name))
                           $$name='';
                            $ismut=0;
                            if(count($model[$key]['gsSearchOptions']['qt'])>1){

                                    $select_list=array();
                                    foreach($model[$key]['gsSearchOptions']['qt'] as $v){
                                        $select_list[$v]=$v;
                                    }
                                    $qt_name='qt-'.$key;
                                    if(!isset($$qt_name))
                                               $$qt_name='';
                                    echo "<div class=\"col-sm-3\" style=\"padding-left:0px;\">";
                                    echo  $this->tag->selectStatic([$qt_name,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "qt$key","value"=>$$qt_name],$select_list);
                                    echo "</div>";
                                    $ismut=1;

                            }else{
                                 //   echo "<input type==hidden name='qt-'.$key value=\"$model[$key]['gsSearchOptions']['qt'][0]\">";
                            }

                            if($ismut==1){
                                $colclass="col-sm-7";
                            }else{
                                $colclass="col-sm-10";
                            }

                           if($model[$key]['type']=='text'){
                                  echo "<div class={$colclass}>";
                                    echo  $this->tag->textField([$name, "size" => 30, "class" => "form-control", "id" => "field".$key,'value'=>$$name]);
                                 echo "</div>";
                           }elseif($model[$key]['type']=='select'){
                                if($model[$key]['gsSearchOptions']['type'][0]=='in'){
                                    echo "<div class={$colclass}>";
                                        foreach($model[$key]['options'] as $k=>$v){
                                                if(is_array($$name)&&in_array($k,$$name)){
                                                       echo   $this->tag->checkField(array($name."[]","value"=>$k ,"class" => "check$key","checked"=>"true"));
                                                       }
                                                else{
                                                       echo   $this->tag->checkField(array($name."[]","value"=>$k ,"class" => "check$key"))  ;
                                                }
                                                 echo $v['text'];
                                        }
                                         echo "</div>";
                                }else{
                                    $select_list=array();
                                    if(isset($model[$key]['class'])&&($model[$key]['class']=='prov'||$model[$key]['class']=='city')){
                                       echo "<div class={$colclass}>";
                                            $class=$model[$key]['class'];
                                         echo  $this->tag->selectStatic([$name,"cols" => 50,"rows" => 4,"class" => "form-control $class", "id" => "field$key","data-$class"=>$$name],$select_list);
                                     echo "</div>";

                                    } elseif($key=="sub_account_id"){
                                        foreach($model[$key]['options'] as $k=>$v){
                                         $select_list[$k]=$v['text'];
                                         }
                                            echo "<div class=\"col-sm-5\" style=\"padding-left:0px;\">". $this->tag->selectStatic([$name,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "field$key","value"=>$$name],$select_list)."</div>";
                                            echo "<div class=\"col-sm-5\">";
                                            echo  " <a href='javascript:;' class=\"userbelongBtnlayer\"  data-obj=\"#fieldsub_account_id\"> <span class=\"icon iconfont icon-sousuo  form-control\" aria-hidden=\"true\" ></span></a>";
                                            echo  "</div>";
                                    }
                                    else{
                                        foreach($model[$key]['options'] as $k=>$v){
                                         $select_list[$k]=$v['text'];
                                         }
                                         echo "<div class={$colclass}>";
                                        echo  $this->tag->selectStatic([$name,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "field$key","value"=>$$name],$select_list);
                                    echo "</div>";
                                    }
                                }

                           }elseif($model[$key]['type']=='checkbox'){
                             echo "<div class={$colclass}>";
                                     foreach($model[$key]['options'] as $k=>$v){
                                          if(is_array($$name)&&in_array($k,$$name)){
                                                echo   $this->tag->checkField(array($name."[]","value"=>$k ,"class" => "check$key","checked"=>"true"));
                                                }
                                         else{
                                                echo   $this->tag->checkField(array($name."[]","value"=>$k ,"class" => "check$key"))  ;
                                         }
                                         echo $v['text'];
                                     }
                                       echo "</div>";
                           } elseif($model[$key]['type']=='radio'){
                             echo "<div class={$colclass}>";
                                   foreach($model[$key]['options'] as $k=>$v){
                                        if($$name==$k)
                                            echo $this->tag->radioField(array('gs-'.$key,"value"=>$k ,"class" => "radio$key","checked"=>"true"));
                                        else
                                            echo $this->tag->radioField(array('gs-'.$key,"value"=>$k ,"class" => "radio$key"));
                                        echo $v['text'];
                                    }
                                      echo "</div>";
                           } elseif($model[$key]['type']=='time'or $model[$key]['type']=='datetime' or $model[$key]['type']=='day'){

                                     if($model[$key]['gsSearchOptions']['type'][0]=='between'){
                                            $v=$$name;
                                            if(!isset($v[0]))
                                                $v[0]='';
                                               if(!isset($v[1]))
                                                  $v[1]='';

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
                                            foreach($optionlist as $k=>$_v){
                                                 $optionstr.="<option value=$k>$_v</option>";
                                            }
                                            echo  "<div class=\"col-sm-2\"><select id='selectTimeSuit' class='form-control gselectTimeSuit' data-key='field$key'>".$optionstr."</select></div>";
                                             echo  "<div class=\"col-sm-4\" style=\"padding-left:0px;\">".$this->tag->textField([$name.'[]', "size" => 30, "class" => "form-control", "id" => "gstartfield".$key,"value"=>$v[0],"placeholder"=>'开始'])."</div>";
                                           echo   "<div class=\"col-sm-4\" style=\"padding-left:0px;\">".$this->tag->textField([$name.'[]', "size" => 30, "class" => "form-control", "id" => "gfield".$key,"value"=>$v[1],"placeholder"=>'至']). "</div>";
                                     }else{
                                          echo "<div class={$colclass}>";
                                            echo  $this->tag->textField([$name, "size" => 30, "class" => "form-control", "id" => "field".$key,"value"=>$$name]);
                                       echo "</div>";
                                     }

                           }elseif($model[$key]['type']=='number'){
                                      echo "<div class={$colclass}>";
                                      echo  $this->tag->numericField(['gs-'.$key, "size" => 30, "class" => "form-control", "id" => "field".$key,'value'=>$$name]);
                                      echo "</div>";
                           }
                           elseif($model[$key]['type']=='suggest'){
                                     $value=$$name;
                                     if(!empty($value))
                                        $keyvalue=$model[$key]['options'][$value]['text'];
                                     else
                                         $keyvalue='';

                                     echo   "<input id=\"{$key}_gsearch\" name=\"gs-{$key}\" type=\"hidden\"/>";
                                     echo  "<input id=\"{$key}_gSuggest\" type=\"text\" class=\"form-control\" value=\"{$keyvalue}\" style=\"width:50%;\"/>";
                                     echo   "<div id=\"{$key}_gsearch_div\"  class=\"ac_results\"></div>";
                           }
                           else{
                                    echo "<div class={$colclass}>";
                                    echo  $this->tag->textField(['gs-'.$key, "size" => 30, "class" => "form-control", "id" => "field".$key,'value'=>$$name]);
                                    echo "</div>";
                           }

                            ?>

                                 {%if model[key]['type']=='datetime' or model[key]['type']=='time' or model[key]['type']=='day'%}

                                    {%if model[key]['gsSearchOptions']['type'][0]=='between'%}
                                           <script>
                                                  $(function(){
                                                       $('#gstartfield{{key}}').datetimepicker({
                                                             autoclose: true,
                                                                format: 'yyyy-mm-dd 00:00:00',
                                                                language:"zh-CN",
                                                                startView: 2,
                                                                minView: 2
                                                      });

                                                       $('#gfield{{key}}').datetimepicker({
                                                              autoclose: true,
                                                              format: 'yyyy-mm-dd 23:59:59',
                                                                language:"zh-CN",
                                                                startView: 2,
                                                                minView: 2
                                                        });
                                                  });
                                            </script>
                                    {%else%}
                                        <script>
                                        $(function(){
                                             $('#field{{key}}').datetimepicker({
                                                    autoclose: true,
                                                       format: 'yyyy-mm-dd',
                                                       language:"zh-CN",
                                                        	startView: 2,
                                                        		minView: 2
                                              });

                                        });

                                        </script>
                                    {%endif%}
                                 {%endif%}



                                 {%if model[key]['type']=='suggest'%}
                                                         <script>
                                                             $(function(){
                                                                          var List='{{sub_account_idJson}}';
                                                                                       List=eval('('+List+')');
                                                                                       var sub_account_id=new Array();
                                                                                       $(List).each(function(i,n){
                                                                                           sub_account_id[i]=new Array(n.id,n.name,' ');
                                                                                       });

                                                                         $("#{{key}}_gSuggest").suggest(sub_account_id,{hot_list:sub_account_id,dataContainer:'#{{key}}_gsearch',onSelect:function(){}, attachObject:'#{{key}}_gsearch_div'});
                                                              });

                                                         </script>

                                 {%endif%}
          </div>
    {%endfor%}
 <div class="form-group">
                   <label for="fieldCreateDate" class="col-sm-2 control-label"></label>
                    <button type="submit" class="btn btn-default btnGss">搜索</button>

 </div>
