     {%for key,model in models%}
           {% if model['ispk']==1 and model['ispk'] is defined%}
                  {{ hidden_field(key) }}
              {% endif %}

            {%if model['edit']==1 and isCreate==0%}
                {%if model['type']=='hidden'%}
                     {{ hidden_field(key) }}
                {%else%}
                    <div class="form-group">
                        <label for="fieldCreateDate" class="col-sm-2 control-label">
                            {%if model['required']==1%}
                             <span class="requireTag">*<span>{{model['lable']|default(key)}}
                            {%else%}
                                {{model['lable']|default(key)}}
                            {%endif%}
                        </label>
                                  {%if key=="sub_account_id" and (model['type']=="select" or model['type']=="suggest")%}
                                   <div class="col-sm-5">
                                {%else%}
                                   <div class="col-sm-10">
                                  {%endif%}
                          <?php
                                if($model['type']=='text'){
                                     $Field=[$key, "size" => 30, "class" => "form-control", "id" => "field".$key];
                                     if(intval($model['required'])==1){
                                             $Field['required']="true";
                                     }

                                     if(intval($model['email'])==1){
                                              $Field['email']="true";
                                     }

                                     if($model['rangelength']!=null){
                                              $Field['rangelength']=$model['rangelength'];
                                     }
                                     if($model['number']==1){
                                               $Field['number']="true";
                                     }
                                     echo  $this->tag->textField($Field);
                                }elseif($model['type']=='select'){
                                   $select_list=array();
                                   $is_multiple=0;
                                    if(isset($model['multiple'])&&$model['multiple']==1){
                                         $is_multiple=1;
                                    }

                                   if(isset($model['class'])&&($model['class']=='prov'||$model['class']=='city')){
                                        $Field=[$key,"cols" => 50,"rows" => 4,"class" => "form-control ".$model['class'], "id" => "field$key","data-v"=>$this->tag->getValue($key)];
                                   }else{
                                        foreach($model['options'] as $k=>$v){
                                           $select_list[$k]=$v['text'];
                                        }
                                        if($is_multiple==1){
                                        $value=$this->view->getVar($key);
                                        $Field=[$key."[]","cols" => 50,"rows" => 8, "class" => "form-control", "id" => "field".$key,"value"=>$value,"style"=>"height:380px;margin-right:10px;"];
                                        }
                                        else
                                         $Field=[$key,"cols" => 50,"rows" => 4, "class" => "form-control", "id" => "field".$key];
                                   }

                                   if(isset($model['required'])&&$model['required']==1)
                                       $Field['required']="true";
                                   if($is_multiple==1)
                                      $Field['multiple']="multiple";
                                   echo  $this->tag->selectStatic($Field,$select_list);
                                }elseif($model['type']=='checkbox'){
                                        foreach($model['options'] as $k=>$v){
                                                    $Field=[$key,"value"=>$k ,"class" => "check$key"];
                                                    if($model['required']==1)
                                                        $Field['required']="true";
                                                   echo   $this->tag->checkField($Field)  ;
                                            echo $v['text'];
                                        }
                                    } elseif($model['type']=='radio'){

                                       foreach($model['options'] as $k=>$v){
                                                    $Field=[$key,"value"=>$k ,"class" => "radio$key","required"=>"true"];
                                                    if($model['required']==1)
                                                        $Field['required']="true";
                                                    if($v['selected']==1)
                                                        $Field['checked']="checked";
                                                   echo   $this->tag->radioField($Field)  ;
                                            echo $v['text'];
                                        }
                                  } elseif($model['type']=='textarea'){
                                        $Field=[$key,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "field$key"];
                                        if($model['required']==1)
                                        $Field['required']="true";

                                         if($model['rangelength']!=null){
                                                $Field['rangelength']=$model['rangelength'];
                                         }
                                        echo  $this->tag->textArea($Field);

                                }elseif($model['type']=='editor'){
                                        $Field=[$key,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "field$key"];
                                        if($model['required']==1)
                                        $Field['required']="true";
                                        echo  $this->tag->textArea($Field);
                                }elseif($model['type']=='time'){
                                        $value=$this->tag->getValue($key);
                                        if(isset($value)&&trim($value)!='')
                                            $value=date('Y-m-d H:i:s',$value);
                                        else
                                            $value='';
                                        $Field=['name'=>$key,'value'=>$value, "size" => 30, "class" => "form-control", "id" => "field".$key];

                                        if($model['required']==1)
                                            $Field['required']="true";
                                        echo  $this->tag->textField($Field);
                                }elseif($model['type']=='day'){
                                     $value=$this->tag->getValue($key);
                                     if(isset($value)&&trim($value)!='')
                                         $value=date('Y-m-d',$value);
                                     else
                                         $value='';
                                     $Field=['name'=>$key,'value'=>$value, "size" => 30, "class" => "form-control", "id" => "field".$key];

                                     if($model['required']==1)
                                         $Field['required']="true";
                                     echo  $this->tag->textField($Field);

                                }elseif($model['type']=='datetime'){
                                        $Field=[$key, "size" => 30, "class" => "form-control", "id" => "field".$key];
                                       if($model['required']==1)
                                            $Field['required']="true";;
                                       echo  $this->tag->textField($Field);
                                }
                                elseif($model['type']=='number'){
                                        $Field=[$key, "size" => 30, "class" => "form-control", "id" => "field".$key];
                                        if($model['required']==1)
                                            $Field['required']="true";
                                        echo  $this->tag->numericField($Field);
                                 }elseif($model['type']=='password'){
                                      $Field=[$key, "size" => 30, "class" => "form-control", "id" => "field".$key];
                                      if($model['required']==1)
                                          $Field['required']="true";
                                       if($model['rangelength']!=null){
                                                $Field['rangelength']=$model['rangelength'];
                                       }

                                      echo  $this->tag->passwordField($Field);
                                }
                                elseif($model['type']=='suggest'){
                                       $value=$this->tag->getValue($key);
                                       if(isset($value))
                                           $keyvalue=$model['options'][$value]['text'];
                                       else
                                           $keyvalue='';
                                         echo   "<input id=\"{$key}_e\" name=\"{$key}\" type=\"hidden\"  value=\"{$value}\"/>";
                                         echo  "<input id=\"{$key}_eSuggest\" type=\"text\" class=\"form-control\" value=\"{$keyvalue}\" style=\"width:95%;\"/>";
                                         echo   "<div id=\"{$key}_e_div\"  class=\"ac_results\"></div>";
                               }elseif($model['type']=='image'){
                                        $value=$this->tag->getValue($key);
                                         $FileField=["field_".$key, "id" => "field_".$key];
                                          $Field=[$key,"id"=>"h_".$key];
                                      if($model['required']==1)
                                           $Field['required']="true";
                                    echo  $this->tag->fileField ($FileField);
                                    echo $this->tag->hiddenField($Field);
                                    if($value){
                                        if($remote==1)
                                            echo "<span id='f_{$key}'><img src='{$remote_server}{$value}' width='80'/></span>";
                                        else
                                            echo "<span id='f_{$key}'><img src='../{$value}'  width='80'/></span>";
                                    }
                                    else
                                        echo "<span id='f_{$key}'></span>";
                               }elseif($model['type']=='file'){
                                 $value=$this->tag->getValue($key);
                                     $FileField=["field_".$key, "id" => "field_".$key];
                                     $Field=[$key,"id"=>"h_".$key];
                                   if($model['required']==1)
                                        $Field['required']="true";
                                 echo  $this->tag->fileField ($FileField);
                                 echo $this->tag->hiddenField($Field);
                                 if($value){
                                    if($remote==1)
                                        echo "<span id='f_{$key}'>{$remote_server}{$value}</span>";
                                     else
                                       echo "<span id='f_{$key}'>{$value}</span>";
                                 }
                                 else
                                    echo "<span id='f_{$key}'></span>";
                               }
                               else{
                                      $Field=[$key, "size" => 30, "class" => "form-control", "id" => "field".$key];
                                      if($model['required']==1)
                                          $Field['required']="true";
                                      echo  $this->tag->textField($Field);
                               }
                           ?>

                        {%if model['type']=='suggest'%}
                            <script>
                                $(function(){
                                             var List='{{sub_account_idJson}}';
                                                          List=eval('('+List+')');
                                                          var sub_account_id=new Array();
                                                          $(List).each(function(i,n){
                                                              sub_account_id[i]=new Array(n.id,n.name,' ');
                                                          });

                                            $("#{{key}}_eSuggest").suggest(sub_account_id,{hot_list:sub_account_id,dataContainer:'#{{key}}_e',onSelect:function(){}, attachObject:'#{{key}}_e_div'});
                                 });

                            </script>
                        {%endif%}

                        </div>
                            {%if key=="sub_account_id" and model['type']=="suggest"%}
                               <div class="col-sm-5">
                                    <a href='javascript:;' class="userbelongBtnlayer"  data-obj="#sub_account_id_e" data-suggest="{{key}}_eSuggest">  <span class="icon iconfont icon-sousuo  form-control" aria-hidden="true" ></span> </a>
                                  </div>
                              {%endif%}
                        </div>
                    {%endif%}




            {%elseif model['create']==1 and isCreate==1 %}
                        {%if model['type']=='hidden'%}
                                 {{ hidden_field(key) }}
                        {%else%}
                               <div class="form-group">
                                            <label for="fieldCreateDate" class="col-sm-2 control-label">
                                                {%if model['required']==1%}
                                                    <span class="requireTag">*<span>{{model['lable']|default(key)}}
                                                {%else%}
                                                   {{model['lable']|default(key)}}
                                                {%endif%}
                                            </label>
                                                 {%if key=="sub_account_id" and (model['type']=="select" or model['type']=="suggest")%}
                                                   <div class="col-sm-5">
                                                 {%else%}
                                                        <div class="col-sm-10">
                                                  {%endif%}
                                              <?php
                                                    if($model['type']=='text'){
                                                        $Field=[$key, "size" => 30, "class" => "form-control", "id" => "field".$key];
                                                        if(intval($model['required'])==1){
                                                                $Field['required']="true";
                                                        }

                                                        if(intval($model['email'])==1){
                                                                 $Field['email']="true";
                                                        }

                                                        if($model['rangelength']!=null){
                                                                 $Field['rangelength']=$model['rangelength'];
                                                        }
                                                        if($model['number']==1){
                                                            $Field['number']="true";
                                                        }
                                                        if(isset($model['remote'])){
                                                            $Field['remote']=$model['remote'];
                                                        }

                                                        echo  $this->tag->textField($Field);
                                                    }elseif($model['type']=='select'){
                                                       $select_list=array();
                                                       $is_multiple=0;
                                                       if(isset($model['multiple'])&&$model['multiple']==1){
                                                            $is_multiple=1;
                                                       }

                                                       if(isset($model['class'])&&($model['class']=='prov'||$model['class']=='city')){
                                                            $Field=[$key,"cols" => 50,"rows" => 4,"class" => "form-control ".$model['class'], "id" => "field$key"];
                                                       }else{
                                                            foreach($model['options'] as $k=>$v){
                                                               $select_list[$k]=$v['text'];
                                                            }
                                                            if($is_multiple==1)
                                                                $Field=['name'=>$key."[]","cols" => 50,"rows" => 4, "class" => "form-control", "id" => "field".$key];
                                                            else
                                                                $Field=[$key,"cols" => 50,"rows" => 4, "class" => "form-control", "id" => "field".$key];
                                                       }
                                                       if($model['required']==1)
                                                           $Field['required']="true";
                                                       if($is_multiple==1)
                                                         $Field['multiple']="multiple";
                                                       echo  $this->tag->selectStatic($Field,$select_list);
                                                    }elseif($model['type']=='checkbox'){
                                                            foreach($model['options'] as $k=>$v){
                                                                    $Field=[$key,"value"=>$k ,"class" => "check$key"];
                                                                    if($model['required']==1)
                                                                        $Field['required']="true";
                                                                   echo   $this->tag->checkField($Field)  ;
                                                            echo $v['text'];
                                                        }

                                                    } elseif($model['type']=='radio'){
                                                        foreach($model['options'] as $k=>$v){
                                                                  $Field=[$key,"value"=>$k ,"class" => "radio$key","required"=>"true"];
                                                                  if($model['required']==1)
                                                                      $Field['required']="true";
                                                                  if($v['selected']==1)
                                                                      $Field['checked']="checked";
                                                                  echo   $this->tag->radioField($Field)  ;
                                                                  echo $v['text'];
                                                        }
                                                  } elseif($model['type']=='textarea'){
                                                    $Field=[$key,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "field$key"];
                                                    if($model['required']==1)
                                                        $Field['required']="true";
                                                        if($model['rangelength']!=null){
                                                            $Field['rangelength']=$model['rangelength'];
                                                        }
                                                        echo  $this->tag->textArea($Field);

                                                  }elseif($model['type']=='editor'){
                                                      $Field=[$key,"cols" => 50,"rows" => 4,"class" => "form-control", "id" => "field$key"];
                                                      if($model['required']==1)
                                                      $Field['required']="true";
                                                      echo  $this->tag->textArea($Field);
                                                }elseif($model['type']=='time'){
                                                         $value=$this->tag->getValue($key);
                                                         if(isset($value)&&trim($value)!='')
                                                             $value=date('Y-m-d H:i:s',$value);
                                                         else
                                                             $value='';
                                                         $Field=['name'=>$key,'value'=>$value, "size" => 30, "class" => "form-control", "id" => "field".$key];

                                                         if($model['required']==1)
                                                             $Field['required']="true";
                                                         echo  $this->tag->textField($Field);

                                                 }elseif($model['type']=='datetime'){
                                                         $Field=[$key, "size" => 30, "class" => "form-control", "id" => "field".$key];
                                                        if($model['required']==1)
                                                             $Field['required']="true";;
                                                        echo  $this->tag->textField($Field);
                                                 }elseif($model['type']=='day'){
                                                   $value=$this->tag->getValue($key);
                                                   if(isset($value)&&trim($value)!='')
                                                       $value=date('Y-m-d',$value);
                                                   else
                                                       $value='';
                                                   $Field=['name'=>$key,'value'=>$value, "size" => 30, "class" => "form-control", "id" => "field".$key];

                                                   if($model['required']==1)
                                                       $Field['required']="true";
                                                   echo  $this->tag->textField($Field);
                                               }elseif($model['type']=='number'){
                                                         $Field=[$key, "size" => 30, "class" => "form-control", "id" => "field".$key];
                                                         if($model['required']==1)
                                                             $Field['required']="true";
                                                         echo  $this->tag->numericField($Field);
                                                  }elseif($model['type']=='password'){
                                                       $Field=[$key, "size" => 30, "class" => "form-control", "id" => "field".$key];
                                                       if($model['required']==1)
                                                           $Field['required']="true";
                                                       if($model['rangelength']!=null){
                                                            $Field['rangelength']=$model['rangelength'];
                                                       }
                                                       echo  $this->tag->passwordField($Field);
                                                 }
                                                elseif($model['type']=='suggest'){
                                                         $value=$this->tag->getValue($key);
                                                         if(isset($value))
                                                            $keyvalue=$model['options'][$value]['text'];
                                                         else
                                                            $keyvalue='';
                                                         echo   "<input id=\"{$key}_e\" name=\"{$key}\" type=\"hidden\" value=\"{$value}\"/>";
                                                         echo  "<input id=\"{$key}_eSuggest\" type=\"text\" class=\"form-control\" value=\"{$keyvalue}\" style=\"width:95%;\"/>";
                                                         echo   "<div id=\"{$key}_e_div\"  class=\"ac_results\"></div>";
                                                }elseif($model['type']=='image'){
                                                         $FileField=["field_".$key, "id" => "field_".$key];
                                                          $Field=[$key,"id"=>"h_".$key];
                                                      if($model['required']==1)
                                                           $Field['required']="true";
                                                    echo  $this->tag->fileField ($FileField);
                                                    echo $this->tag->hiddenField($Field);
                                                    echo "<span id='f_{$key}'></span>";
                                                }elseif($model['type']=='file'){
                                                     $FileField=["field_".$key, "id" => "field_".$key];
                                                     $Field=[$key,"id"=>"h_".$key];
                                                   if($model['required']==1)
                                                        $Field['required']="true";
                                                 echo  $this->tag->fileField ($FileField);
                                                 echo $this->tag->hiddenField($Field);
                                                   echo "<span id='f_{$key}'></span>";
                                                }
                                                else{
                                                        $Field=[$key, "size" => 30, "class" => "form-control", "id" => "field".$key];
                                                        if($model['required']==1)
                                                            $Field['required']="true";
                                                        echo  $this->tag->textField($Field);
                                                }
                                           ?>
                                        </div>

                                              {%if model['type']=='suggest'%}
                                                 <script>
                                                     $(function(){
                                                                  var List='{{sub_account_idJson}}';
                                                                               List=eval('('+List+')');
                                                                               var sub_account_id=new Array();
                                                                               $(List).each(function(i,n){
                                                                                   sub_account_id[i]=new Array(n.id,n.name,' ');
                                                                               });

                                                                 $("#{{key}}_eSuggest").suggest(sub_account_id,{hot_list:sub_account_id,dataContainer:'#{{key}}_e',onSelect:function(){}, attachObject:'#{{key}}_e_div'});
                                                      });
                                                 </script>
                                             {%endif%}

                                             {%if key=="sub_account_id" and model['type']=="suggest"%}
                                                   <div class="col-sm-5">
                                                   <a href='javascript:;' class="userbelongBtnlayer"  data-obj="#sub_account_id_e" data-suggest="{{key}}_eSuggest">  <span class="icon iconfont icon-sousuo  form-control" aria-hidden="true" ></span>
                                                   </a>
                                                      </div>
                                              {%endif%}
                                    </div>
                       {%endif%}
             {%endif%}
    {%endfor%}

    <div class="error"></div>



