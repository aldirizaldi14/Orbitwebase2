@section('pageTitle', 'Production')

@extends("layouts/app")

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-12">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">@yield('pageTitle')</h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <div class="row">
                                <div class="col-md-6 col-md-1"></div>
                                <div class="col-md-6 col-sm-11">
                                    <input type="text" class="form-control pull-left" id="txtSearch" placeholder="Search" style="width: 200px; height: 40px; margin-right: 20px; margin-left: 70px;">
                                    <button  type="button" class="btn btn-accent pull-left m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" id="btnDownload" name="btnDownload" >
                                        <i class="m-nav__link-icon fa fa-download"></i>
                                    </button>
                                    <button type="button" class="btn btn-accent pull-left m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" id="btnAdd" hidden="">
                                        <i class="m-nav__link-icon fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="table-responsive">
                            <table id="tableData" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Time</th>
                                        <th>Code</th>
                                        <th>Product</th>
                                        <th>Line</th>
                                        <th>Shift</th>
                                        <th>Batch</th>
                                        <th>Qty</th>
                                        <th>Remark</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                            </table>
                            <tbody></tbody>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalForm" class="modal" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">@yield('pageTitle') Form</h5>
        <a href="#"><i class="m-nav__link-icon fa fa-close" data-dismiss="modal" aria-label="Close"></i></a>
    </div>
    <form class="form-horizontal" id="formData">
        <div class="modal-body">
            <div class="form-group">
                <div class="row">
                    <label class="col-md-4 control-label">Qty *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="production_qty" required="">
                    </div>
                </div>
            </div>
            <div class="form-group" style="color: red;">
                <br/>You need to fill all field with * mark
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="btnSave">Save</button>
        </div>
    </form>
</div>
</div>
</div>
<!-- End modal form -->

@endsection

@section('footer')
<script type="text/javascript">
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var production_id = '';

    $("#btnAdd").click(function(){
        production_id='';
        $("input[name=production_qty").val('');
        $('#modalForm').modal('show');
    });

    var tableColumn = [
        { data: "production_id", width : 50, sortable: false},
        { data: "production_time" },
        { data: "production_code" },
        { data: "product_code" },
        { data: "line_name" },
        { data: "production_shift" },
        { data: "production_batch" },
        { data: "production_qty" },
        { data: "production_remark" },
        { data: "production_id", width: 100, sortable: false}
    ];
    var orderSort = '';
    var orderDir = '';
   var buttonComon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node )
                {
                    return column === 5 ?
                    data.replace( /[$,]/g, '' ) :
                    data;
                }
            }
        }
    };

    //fungsi dibawah ini untuk melakukan export all data karena menggunakan serverside dan length data
    function newexportaction(e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;
    dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;
        dt.one('preDraw', function (e, settings) {
            // Call the original action function
            if (button[0].className.indexOf('buttons-copy') >= 0) {
                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
            dt.one('preXhr', function (e, s, data) {
                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                // Set the property to what it was before exporting.
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });
            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);
            // Prevent rendering of the full data to the DOM
            return false;
        });
    });
        // Requery the server with the new one-time export settings
        dt.ajax.reload();
    };
    //For Export Buttons available inside jquery-datatable "server side processing" - End

    

    var table = $("#tableData").DataTable({
        //komponen untuk menampilakn tombol excel,print,pdf dan fungsi untuk download datatable
        dom: 'Bfrtip',
        "buttons" : 
        [

            {
                               "extend": 'copy',
                               "text": '<i class="fa fa-file-text-o" style="color: green;"></i>',
                               "titleAttr": 'Copy',                               
                               "action": newexportaction,
                               exportOptions: 
                               {
                                columns: [0, 1, 2, 3, 4, 5]
                               }
                           },
                           {
                               "extend": 'excel',
                               "text": '<i class="fa fa-file-excel-o" style="color: green;"></i>',
                               "titleAttr": 'Excel',                               
                               "action": newexportaction,
                               exportOptions: 
                               {
                                columns: [0, 1, 2, 3, 4, 5]
                               },
                               filename: function(){
                                    var d = new Date();
                                    var n = d.getTime();
                                    return 'Orbit Production' + " " + d;
                                }
                           },
                           {
                               "extend": 'csv',
                               "text": '<i class="fa fa-file-text-o" style="color: green;"></i>',
                               "titleAttr": 'CSV',                               
                               "action": newexportaction,
                               exportOptions: 
                               {
                                columns: [0, 1, 2, 3, 4, 5]
                               },
                               filename: function(){
                                    var d = new Date();
                                    var n = d.getTime();
                                    return 'Orbit Production' + " " + d;
                                }
                           },
                           {
                               "extend": 'pdf',
                               "text": '<i class="fa fa-file-pdf-o" style="color: green;"></i>',
                               "titleAttr": 'PDF',                               
                               "action": newexportaction,
                               exportOptions: 
                               {
                                columns: [0, 1, 2, 3, 4, 5]
                               }
                               
                           },
                           {
                                "extend": 'print',
                                "text": '<i class="fa fa-print" style="color: green;"></i>',
                                "titleAttr": 'Print',                                
                                "action": newexportaction,
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3, 4, 5 ]
                                },
                               filename: function(){
                                    var d = new Date();
                                    var n = d.getTime();
                                    return 'Orbit Production' + " " + d;
                                }

                           }

        ],
        
        deferRender: true,
        filter : false,
        sortable: true,
        info: true,
        paging: true,
        processing: true,
        serverSide: true,
        ordering : true,
        order: [[ 1, "desc" ]],
        ajax: function(data, callback, settings) {
            orderSort = tableColumn[data.order[0].column].data;
            orderDir = data.order[0].dir;
            $.getJSON('{{ url('production/data') }}', {
                draw: data.draw,
                pageLength: 10,
                length: data.length,
                start: data.start,
                filter: $("#txtSearch").val(),
                sort:tableColumn[data.order[0].column].data,
                dir:data.order[0].dir
            }, function(res) {
                callback({
                    recordsTotal: res.recordsTotal,
                    recordsFiltered: res.recordsFiltered,
                    data: res.listData
                });
            });
        },
        columns: tableColumn,
        columnDefs: [
            {
                render: function(data,type,row,index){
                    var info = table.page.info();
                    return index.row+info.start+1;
                },
                targets : [0]
            },
            {
                render: function(data,type,row,index){
                    content = '<button type="button" class="btn btn-edit btn-accent m-btn--pill btn-sm m-btn m-btn--custom" data-index="'+ index.row +'"><i class="m-nav__link-icon fa fa-pencil"></i></button>';
                    content += '<button type="button" class="btn btn-delete btn-accent m-btn--pill btn-sm m-btn m-btn--custom" data-index="'+ index.row +'"><i class="m-nav__link-icon fa fa-trash"></i></button>';
                    return content;
                },
                targets : [9]
            },
        ],
        drawCallback: function(e,response){
            $(".btn-edit").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();

                production_id = data.production_id;
                $("input[name=production_qty]").val(data.production_qty);
                $('#modalForm').modal('show');
            });
            $(".btn-delete").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();

                swal.fire({
                    title: "Delete "+ data.production_code +" ?",
                    type: "question",
                    showCancelButton : true,
                    focusCancel : true,
                    dangerMode: true,
                    closeOnClickOutside : false
                })
                .then((confirm) => {
                    if (confirm.value) {
                        $.ajax({
                            url: '{{ url('production') }}/delete/' + data.production_id,
                            method: "post",
                            dataType : 'json'
                        })
                        .done(function(resp) {
                            console.log(resp);
                            if (resp.success) {
                                swal.fire("Info", resp.message, "success");
                                table.ajax.reload();
                            }else{
                                swal.fire("Warning", resp.message, "warning");
                            }
                        })
                        .fail(function() {
                            swal.fire("Warning", 'Unable to process request at this moment', "warning");
                        });
                    } else {
                        event.preventDefault();
                        return false;
                    }
                });
            });
        }
    });
    $("#btnDownload").on("click", function() {
        table.button( '.buttons-excel' ).trigger();
    }); //fungsi ini untuk memanggil id button samping kolom search supaya bisa untuk download excel

    $("#production_warehouse_id").select2({
        theme:'bootstrap',
        ajax: {
            url: '{{ url('warehouse/data') }}',
            dataType: 'json',
            type: "GET",
            delay: 250,
            data: function (params) {
                return {
                    filter: params.term
                };
            },
            processResults: function(data, page) {
                var result_data = data.listData;
                if(data.recordsTotal >= 1){
                    return {
                        results: $.map(result_data, function (item) {
                            return {
                                text: item.warehouse_name,
                                id: item.warehouse_id
                            }
                        })
                    };
                }
                else
                {
                    return { results : null };
                }
            }
        }
    });

    $("#formData").submit(function (e)
    {
        e.preventDefault();
        var btn = $("#btnSave");
        btn.text('Processing...').attr('disabled', true);

        var postData = new FormData($('#formData')[0]);

        $.ajax({
            url: '{{ url('production') }}' + (production_id ? '/' + production_id : ''),
            method: "POST",
            data: postData,
            processData: false,
            cache: false,
            contentType: false,
            dataType : 'json'
        })
        .done(function(resp) {
            if (resp.success) {
                $("#modalForm").modal("hide");
                swal.fire("Info", resp.message, "success");
                table.ajax.reload();
            }else{
                swal.fire("Warning", resp.message, "warning");
            }
        })
        .fail(function() {
            swal.fire("Warning", 'Unable to process request at this moment', "warning");
        })
        .always(function() {
            btn.text('Simpan');
            btn.attr('disabled', false);
        });
    });

    $("#txtSearch").typeWatch({
        callback: function (value) { table.ajax.reload(); },
        wait: 750,
        highlight: true,
        allowSubmit: false,
        captureLength: 1
    });

    
});
</script>

    <script type="text/javascript" src="js/datetime.js"></script>
    <script type="text/javascript" src="js/jszip.min.js"></script>
    <script type="text/javascript" src="js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="js/buttons.print.min.js"></script>
    <script type="text/javascript" src="js/pdfmake.min.js"></script>
    <script type="text/javascript" src="js/vfs_fonts.js"></script>
    <script type="text/javascript" src="js/dataTables.select.min.js"></script>


@endsection
