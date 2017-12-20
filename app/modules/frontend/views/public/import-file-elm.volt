
<!--{{ form("/customer/ImportByModel", "method":"post", "autocomplete" : "off", "class" : "form-horizontal",'enctype':"multipart/form-data") }}-->
    <div class="form-group">
                    <label for="fieldCreateDate" class="col-sm-2 control-label">导入csv文件</label>
                    <div class="col-sm-10">
                     {{ file_field('fileCsv', 'class': 'form-control','id':'fileCsv') }}
                    </div>
    </div>




<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ submit_button('提交', 'class': 'btn btn-primary btnImportByFile','data-url':'/customer/ImportByModel') }}
    </div>
</div>

