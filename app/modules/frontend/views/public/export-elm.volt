 <div class="form-group">
        <nav>
            <ul class="pagination">
                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;选择导出字段</li>
                <li><input type="checkbox" class="checkAll" data-obj="exportColumn"> 全选</li>
                <li><input type="checkbox" class="checkRev" data-obj="exportColumn"> 反选</li>
            </ul>
        </nav>


        <div class="col-sm-10" style="margin:5px;">
            {%for column in columns%}
                <input type="checkbox" value="{{column}}" name="exportElm" class="exportColumn" data-obj="checkExportAll"/> {{model[column]['lable']}} &nbsp; &nbsp;
            {%endfor%}
        </div>
</div>


<input type="hidden" value="{{link~'&page='~page~'&total_items='~total_items}}" id='link'/>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ submit_button('提交', 'class': 'btn btn-primary btnMakeExport') }}
    </div>
</div>

