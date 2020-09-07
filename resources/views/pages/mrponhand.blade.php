@section('pageTitle', 'MRP Onhand Master')
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

                                <div id="buttonupdatedailyplan" class="col-md-6 col-sm-11">
                                    <button data-toggle="tooltip" data-placement="bottom"
                                    title="Synchronize Data" type="button"
                                     class="btn btn-accent pull-left m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" id="refresh">
                                        <i  class="m-nav__link-icon fa fa-refresh"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <div class="row">
                                <div class="col-md-6 col-md-1"></div>
                                <div class="col-md-6 col-sm-11">
                                    <input type="text" class="form-control pull-left" id="txtSearch" placeholder="Search" style="width: 200px; height: 40px; margin-right: 10px;">
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
                                        <th>Periode </th>
                                        <th>Item Code</th>
                                        <th>UOM</th>
										<th>Beg Stock</th>
                                        <th>PO OUT QTY</th>
                                        <th>PO RCV QTY</th>
                                        <th>Creation Date</th>
                                        <th>Last Update</th>
                                        <th>VT Stock</th>
                                        <th>VT Remain</th>
										<!--<th>&nbsp;</th>-->
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
    var count_id = '';

    $("#btnAdd").click(function(){
        count_id='';

        $("input[name=item_number]").val('');
        $("input[name=item_type]").val('');
        $("input[name=quantity]").val('');

        $('#modalForm').modal('show');
    });

    var tableColumn = [
        { data: "item_code", width : 30, sortable: false},
        { data: "period_name" },
        { data: "item_code" },
        { data: "uom" },
		{ data: "beg_stock" },
        { data: "po_out_qty" },
        { data: "po_rcv_qty" },
        { data: "date_time" },
        { data: "last_update" },
        { data: "vt_stock" },
        { data: "vt_onh_remain" , width : 85, sortable: false}


    ];
    var orderSort = '';
    var orderDir = '';
    var table = $("#tableData").DataTable({
        filter : false,
        sortable: true,
        info: true,
        paging: true,
        processing: true,
        serverSide: true,
        ordering : true,
        order: [[ 0, "desc" ]],
        ajax: function(data, callback, settings) {
            orderSort = tableColumn[data.order[0].column].data;
            orderDir = data.order[0].dir;
            $.getJSON('{{ url('mrponhand/data') }}', {
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


        ],
        drawCallback: function(e,response){
            $(".btn-edit").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();

                header_id = data.header_id;
                $("input[name=item_number]").val(data.item_number);
                $("input[name=item_type]").val(data.item_type);
                $("input[name=quantity]").val(data.quantity);

                $('#modalForm').modal('show');
            });
            $(".btn-delete").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();
                swal.fire({
                    title: "Delete "+ data.item_code +"?",
                    type: "question",
                    showCancelButton : true,
                    focusCancel : true,
                    dangerMode: true,
                    closeOnClickOutside : false
                })
                .then((confirm) => {
                    if (confirm.value) {
                        $.ajax({
                            url: '{{ url('itemstatic') }}/delete/' + data.count_id,
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

    $("#formData").submit(function (e)
    {
        e.preventDefault();
        var btn = $("#btnSave");
        btn.text('Processing...').attr('disabled', true);

        var postData = new FormData($('#formData')[0]);

        $.ajax({
            url: '{{ url('itemstatic') }}' + (count_id ? '/' + count_id : ''),
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
        captureLength: 2
    });

    $("#refresh").click(function(){
        var btn = $("#refresh");
        btn.html('Processing... <i  class="m-nav__link-icon fa fa-refresh fa-spin"></i>').attr('disabled', true);

        $.ajax({
            url: '{{ url('mrp') }}/mrp_onhand',
            method: "POST",
            dataType : 'json',
            data : {
                sort : orderSort,
                dir : orderDir
            }
        })
        .done(function(resp) {
            if (resp.success) {
                window.open(resp.file);
            }else{
                swal.fire("success!", resp.message, "success");
            }
        })
        .fail(function() {
            swal.fire("Warning", 'Unable to process request at this moment', "warning");
        })
        .always(function() {
            btn.html('<i  class="m-nav__link-icon fa fa-refresh"></i>').attr('disabled', false);
        });
    });
});
</script>

<script>
$(document).ready(function(){
  //$('[data-toggle="tooltip"]').tooltip();
  $('[data-toggle="tooltip"]').tooltip({ trigger: "hover",placement: 'bottom',
  delay: { "show": 100, "hide": 100 },
  offset: '0 10',
  template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner bg-success rounded-pill shadow"></div></div>' });

});
</script>
<link rel="stylesheet" href="css/positionmodaldailyplan.css" type="text/css">
@endsection
