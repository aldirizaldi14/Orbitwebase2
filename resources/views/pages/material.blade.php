@section('pageTitle', 'Material')
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
                                    <input type="text" class="form-control pull-left" id="txtSearch" placeholder="Search" style="width: 200px; height: 40px; margin-right: 10px; margin-left: 180px;">
                                    <button type="button" class="btn btn-accent pull-left m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" id="btnAdd">
                                        <i class="m-nav__link-icon fa fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-accent pull-left m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" id="btnDownload" >
                                        <i class="m-nav__link-icon fa fa-download"></i>
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
                                        <th>Code</th>
                                        <th>Alternative Code</th>
                                        <th>Description</th>
                                        <th>Onhand</th>
                                        <th>Lot Max</th>
                                        <th>Location</th>
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
                    <label class="col-md-4 control-label">Code *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="product_code" required="">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-4 control-label">Alternative Code</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="product_code_alt" required="">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-4 control-label">Description *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="product_description" required="">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-4 control-label">Location </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="product_location_alt" >
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

<div id="modalForm_IO" class="modal" role="dialog" aria-hidden="true">
<div class="modal-dialog" style="max-width: 45%; max-height:5%; " role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Detail I/O Form <a id="datetime"></a> </h5>

        <a href="#"><i class="m-nav__link-icon fa fa-close" data-dismiss="modal" aria-label="Close"></i></a>
    </div>
    <form class="form-horizontal">
        <div class="modal-body">

            <div class="table-responsive">
                <table id="tableDetail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Model Number</th>
                            <th>WH Material</th>
                            <th>Production</th>
                            <th>Transaction Date</th>
                            <th>IN</th>
                            <th>OUT</th>
                            <th>Total</th>
                            <th>End Stock</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btnPrint_IO">
            <i class="m-nav__link-icon fa fa-download"></i>
            Print
            </button>
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
    var product_id = '';
    $("#btnAdd").click(function(){
        product_id='';
        $("input[name=product_code").val('');
        $("input[name=product_code_alt").val('');
        $("input[name=product_description").val('');
        $("input[name=product_location_alt").val('');
        $('#modalForm').modal('show');
    });

    var tableColumn = [
        { data: "product_id", width : 50, sortable: false},
        { data: "product_code" },
        { data: "product_code_alt" },
        { data: "product_description" },
        { data: "QTY",render: $.fn.dataTable.render.number(" ",".", 0) },
        { data: "product_max_alt" },
        { data: "product_location_alt" },
        { data: "product_id", width: 100, sortable: false}
    ];
    var orderSort = '';
    var orderDir = '';


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

    var table = $("#tableData").DataTable({
        dom : 'lrtip',
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
            $.getJSON('{{ url('material/data') }}', {
                draw: data.draw,
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
                    content += '<button data-toggle="tooltip" data-placement="bottom" title="Detail I/O " type="button" class="btn btn-detail btn-accent m-btn--pill btn-sm m-btn m-btn--custom" data-index="'+ index.row +'"><i class="m-nav__link-icon fa fa-exchange"></i></button>';
                    return content;
                },
                targets : [7]
            },
        ],
        drawCallback: function(e,response){
            $(".btn-edit").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();

                product_id = data.product_id;
                $("input[name=product_code]").val(data.product_code);
                $("input[name=product_code_alt]").val(data.product_code_alt);
                $("input[name=product_description]").val(data.product_description);
                $("input[name=product_location_alt]").val(data.product_location_alt);
                $('#modalForm').modal('show');
            });
            $(".btn-detail").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();
                product_id = data.product_id;
                tableDetail.ajax.reload();
                $('#modalForm_IO').modal('show');
            });
        }
    });


    var tableColumnDetail = [
        { data: "SEGMENT1", width : 10, sortable: false},
        { data: "SEGMENT1" },
        { data: "SUBINVENTORY_CODE" },
        { data: "INVENTORY_TO" },
        { data: "TRANSACTION_DATE"},
        { data: "INPUT",render: $.fn.dataTable.render.number(",",".", 0) },
        { data: "OUT",render: $.fn.dataTable.render.number(",",".", 0) },
        { data: "TRANSACTION_QUANTITY",render: $.fn.dataTable.render.number(",",".", 0) },
        { data: "ACTUAL_QTY",render: $.fn.dataTable.render.number(",",".", 0) }

    ];

    var tableDetail = $("#tableDetail").DataTable({
        dom : 'rtip',
        "buttons": [
                           {
                                "extend": 'print',
                                footer: true ,
                                "text": '<i class="fa fa-print" style="color: green;"></i>',
                                "titleAttr": 'Print',
                                "action": newexportaction,
                                customize: function ( win ) {
                                        $(win.document.body)
                                            .css( 'font-size', '10pt');

                                        $(win.document.body).find( 'table' )
                                            .addClass( 'compact' )
                                            .css( 'font-size', 'inherit');

                                        $(win.document.body).find('h1').css('font-size', '12pt');
                                        $(win.document.body).find('h1').css('text-align', 'center');
                                    },
                                    title: function(){
                                        var printTitle = 'Orbit Detail I/O ';
                                        var d = new Date();
                                        return printTitle + " " + " " + d.toLocaleString();
                                    }
                           }
        ],
        deferRender: true,
        filter : false,
        sortable : true,
        info: false,
        paging: false,
        processing: true,
        serverSide: true,
        ordering : true,
        order: [[ 1, "asc" ]],
        ajax: function(data, callback, settings) {
            $.getJSON('{{ url('material/detail') }}', {
                draw: data.draw,
                product_id: product_id,
                pageLength: 10,

            }, function(res) {
                callback({
                    recordsTotal: res.recordsTotal,
                    recordsFiltered: res.recordsFiltered,
                    data: res.listData
                });
            }
            );
        },

        "footerCallback": function ( row, data, start, end, display, e, response ) {
            var api = this.api(), data;

            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
         var col7 = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
         var col8 = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(b);
                }, 0 );

            // Update footer by showing the total with the reference of the column index
            $( api.column( 0 ).footer() ).html('Total');
            $( api.column( 8 ).footer() ).html(col7+col8);
        },

        columns: tableColumnDetail,
        columnDefs: [
            {
                   render: function(data,type,row,index){
                    var info = table.page.info();
                    return index.row+info.start+1;
                },
                targets : [0]
            },
            {
                render:function(data)
                {
                return moment(data).format('YYYY-MM-DD');
                },
                targets: [4]
            }
        ],
    "rowCallback": function(row, data, index){
    	$(row).find('td:eq(8)').css('color', 'white');
    },

    });

    $("#btnPrint_IO").on("click", function() {
        tableDetail.button( '.buttons-print' ).trigger();
        });
    // Add event listener for opening and closing details

    $("#formData").submit(function (e)
    {
        e.preventDefault();
        var btn = $("#btnSave");
        btn.text('Processing...').attr('disabled', true);

        var postData = new FormData($('#formData')[0]);

        $.ajax({
            url: '{{ url('material') }}' + (product_id ? '/' + product_id : ''),
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


    /*to button save detail I/O form*/
        $("#formData_IO").submit(function (e)
        {
        e.preventDefault();
        var btn = $("#btnSave_IO");
        btn.text('Processing...').attr('disabled', true);

        var postData = new FormData($('#formData')[0]);

        $.ajax({
            url: '{{ url('material') }}' + (product_id ? '/' + product_id : ''),
            method: "POST",
            data: postData,
            processData: false,
            cache: false,
            contentType: false,
            dataType : 'json'
        })
        .done(function(resp) {
            if (resp.success) {
                $("#modalForm_IO").modal("hide");
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

    /*end save detail I/O form*/

    $("#txtSearch").typeWatch({
        callback: function (value) { table.ajax.reload(); },
        wait: 750,
        highlight: true,
        allowSubmit: false,
        captureLength: 2
    });

    $("#btnDownload").click(function(){
        var filter = $("#txtSearch").val();
        $.ajax({
            url: '{{ url('material') }}/export',
            method: "POST",
            dataType : 'json',
            data : {
                filter : filter,
                sort : orderSort,
                dir : orderDir
            }
        })
        .done(function(resp) {
            if (resp.success) {
                window.open(resp.file);
            }else{
                swal.fire("Warning", resp.message, "warning");
            }
        })
        .fail(function() {
            swal.fire("Warning", 'Unable to process request at this moment', "warning");
        });
    });
});
</script>

<script>
var dt = new Date();
document.getElementById("datetime").innerHTML = dt.toLocaleString();
</script>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip({ trigger: "hover",placement: 'bottom',
  delay: { "show": 100, "hide": 100 },
  offset: '0 10',
  template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner bg-success rounded-pill shadow"></div></div>' });

});
</script>
    <script type="text/javascript" src="js/datetime.js"></script>
    <script type="text/javascript" src="js/moment.min.js"></script>
    <script type="text/javascript" src="js/jszip.min.js"></script>
    <script type="text/javascript" src="js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="js/buttons.print.min.js"></script>
    <script type="text/javascript" src="js/dataTables.select.min.js"></script>

@endsection
