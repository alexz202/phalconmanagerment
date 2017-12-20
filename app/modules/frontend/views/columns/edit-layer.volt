{%extends "base-layer.volt"%}

{%block content%}
  {{javascript_include('js/columns.js')}}
<p></p>
{{ form("columns/save", "method":"post", "autocomplete" : "off", "class" : "form-horizontal form-edit") }}
     {%set isCreate=0%}
          {% include "public/edit-elm" with{'isCreate':isCreate}%}

          <div class="form-group"  id="co-search-div" style="display:none;">
                        <label for="fieldCreateDate" class="col-sm-2 control-label">
                            搜索QT/TYPE
                        </label>

             <div class="col-sm-5">
                    <select name="sqt" class="form-control" style="width:90%">
                         <option value="=" {%if sqt=="="%} selected{%endif%} >=</option>
                          <option value="=,like" {%if sqt=="=,like"%} selected{%endif%}>=,like</option>
                    </select>
             </div>
            <div class="col-sm-5">
                     <select name="stype" class="form-control" style="width:90%">
                        <option value="and" {%if stype=="and"%} selected{%endif%} >and</option>
                         <option value="in" {%if stype=="in"%} selected{%endif%}>in</option>
                        <option value="between" {%if stype=="between"%} selected{%endif%}>between</option>
                    </select>
              </div>
          </div>

          <div class="form-group" id="co-gsearch-div" style="display:none;">
                               <label for="fieldCreateDate" class="col-sm-2 control-label">
                                   高级搜索QT/TYPE
                               </label>
                        <div class="col-sm-5">
                            <select name="gsqt" class="form-control" style="width:90%">
                               <option value="=" {%if gsqt=="="%} selected{%endif%} >=</option>
                               <option value="=,like" {%if gsqt=="=,like"%} selected{%endif%}>=,like</option>
                           </select>

                        </div>
                        <div class="col-sm-5">
                            <select name="gstype" class="form-control" style="width:90%">
                                 <option value="and" {%if gstype=="and"%} selected{%endif%} >and</option>
                                 <option value="in" {%if gstype=="in"%} selected{%endif%}>in</option>
                                <option value="between" {%if gstype=="between"%} selected{%endif%}>between</option>
                           </select>

                        </div>
                 </div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">

    </div>
</div>

</form>
{%endblock%}