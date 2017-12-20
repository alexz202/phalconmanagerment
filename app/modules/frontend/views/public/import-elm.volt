 <div class="form-group">
        <nav>
            <ul class="pagination">
                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;选择导入字段</li>
                <li><input type="checkbox" class="checkAllImport" data-obj="importColumn"> 全选</li>
                <li><input type="checkbox" class="checkRevImport" data-obj="importColumn"> 反选</li>
            </ul>
        </nav>


        <div class="col-sm-10" style="margin:5px;">
            {%for column in columns%}
                {%if model[column]['required']==1%}
                    <input type="checkbox" value="{{column}}" name="importElm" class="importColumn_" data-obj="checkExportAll_" checked=true disabled=true> {{model[column]['lable']}} &nbsp; &nbsp;
                {%else%}
                    <input type="checkbox" value="{{column}}" name="importElm" class="importColumn" data-obj="checkExportAll"> {{model[column]['lable']}} &nbsp; &nbsp;
                {%endif%}
            {%endfor%}
        </div>
</div>



<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ submit_button('提交', 'class': 'btn btn-primary btnMakeImport','data-url':'/customer/makeImportModel') }}
    </div>
</div>

