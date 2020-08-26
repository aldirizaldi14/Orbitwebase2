@section('pageTitle', 'Item Static')
@extends("layouts/app")
@section('content')

<link rel="stylesheet" href="css/position.css" type="text/css">
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
                                    <input type="text" class="form-control pull-left" id="txtSearch" placeholder="Search" style="width: 200px; height: 40px; margin-right: 10px; margin-left: 175px;">
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
                                        <th>Item </th>
                                        <th>Description</th>
                                        <th>Uom</th>
										<th>Type</th>
                                        <th>Spq</th>
                                        <th>Moq</th>
                                        <th>Terms</th>
                                        <th>ExWork</th>
                                        <th>LT</th>
                                        <th>Yield</th>
                                        <th>ST</th>
                                        <th>Cost</th>
                                        <th>Poq</th>
                                        <th>S_Stock</th>
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
<div class="modal-dialog" style="max-width: 50%;" role="document">
<div class="modal-content ">
    <div class="modal-header">
        <h5 class="modal-title">@yield('pageTitle') Form</h5>
        <a href="#"><i class="m-nav__link-icon fa fa-close" data-dismiss="modal" aria-label="Close"></i></a>
    </div>
    <form class="form-horizontal" id="formData">


        <!--cek-->
        <div class="modal-body">
            <table>
                <tr>
                    <td id="inputleft" >Item Description *</td> <td id="outerleft"><input type="text" class="form-control" name="item_desc" required=""></td>
                    <td id="inputleft">UOM *</td><td><input type="text" class="form-control" name="uom" required=""></td>
                </tr>

                <tr>
                    <td id="inputleft" >Status *</td> <td id="outerleft"><input type="text" class="form-control" name="status" required=""></td>
                    <td id="inputleft">Item Type *</td><td><input type="text" class="form-control" name="item_type" required=""></td>
                </tr>

                <tr>
                    <td id="inputleft" >SPQ *</td> <td id="outerleft"><input type="text" class="form-control" name="spq" required=""></td>
                    <td id="inputleft">MOQ *</td><td><input type="text" class="form-control" name="moq" required=""></td>
                </tr>
                <tr>
                    <td id="inputleft">Terms Carrier *</td><td id="outerleft"><input type="text" class="form-control" name="terms_carrier" required=""></td>
                    <td id="inputleft">Ex Work Time *</td><td><input type="text" class="form-control" name="ex_work_lt" ></td>
                </tr>
                <tr>
                    <td id="inputleft">Fob Time *</td><td id="outerleft"><input type="text" class="form-control" name="fob_lt" ></td>
                    <td id="inputleft">Trading Time *</td><td><input type="text" class="form-control" name="trading_lt" ></td>
                </tr>
                <tr>
                    <td id="inputleft">Logistic Time *</td><td id="outerleft"><input type="text" class="form-control" name="logistic_lt" ></td>
                    <td id="inputleft">Customs Time *</td><td><input type="text" class="form-control" name="customs_lt" required=""></td>
                </tr>
                <tr>
                    <td id="inputleft">Yield *</td><td id="outerleft"><input type="text" class="form-control" name="yield" required=""></td>
                    <td id="inputleft">Safety Time *</td><td><input type="text" class="form-control" name="safety_time" required=""></td>
                </tr>
                <tr>
                    <td id="inputleft">Unit Cost *</td><td id="outerleft"><input type="text" class="form-control" name="unit_cost" ></td>
                    <td id="inputleft">POQ *</td><td><input type="text" class="form-control" name="poq" ></td>
                </tr>
                <tr>
                    <td id="inputleft">Safety Stock *</td><td id="outerleft" ><input type="text" class="form-control" name="safety_stock" ></td>
                </tr>
            </table>

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
    var count_id = '';

    $("#btnAdd").click(function(){
        count_id='';

        $("input[name=item_desc]").val('');
        $("input[name=uom]").val('');
        $("input[name=status]").val('');
        $("input[name=item_type]").val('');
        $("input[name=spq]").val('');
        $("input[name=moq]").val('');
        $("input[name=terms_carrier]").val('');
        $("input[name=ex_work_lt]").val('');
        $("input[name=fob_lt]").val('');
        $("input[name=trading_lt]").val('');
        $("input[name=logistic_lt]").val('');
        $("input[name=customs_lt]").val('');
        $("input[name=yield]").val('');
        $("input[name=safety_time]").val('');
        $("input[name=unit_cost]").val('');
        $("input[name=poq]").val('');
        $("input[name=safety_stock]").val('');

        $('#modalForm').modal('show');
    });

    var tableColumn = [
        { data: "count_id", width : 30, sortable: false},
        { data: "item_code" },
        { data: "item_desc" },
        { data: "uom" },
        { data: "item_type" },
		{ data: "spq",render: $.fn.dataTable.render.number(",", ".", 0) },
        { data: "moq",render: $.fn.dataTable.render.number(",", ".", 0) },
        { data: "terms_carrier" },
        { data: "ex_work_lt",render: $.fn.dataTable.render.number(" ",".", 0) },
        { data: "logistic_lt",render: $.fn.dataTable.render.number(" ",".", 0) },
        { data: "yield" },
        { data: "safety_time",render: $.fn.dataTable.render.number(" ",".", 0)  },
        { data: "unit_cost", render: $.fn.dataTable.render.number(",", ".", 2) },
        { data: "poq" , render: $.fn.dataTable.render.number(",", ".", 0) },
        { data: "safety_stock"},
        { data: "count_id", width : 100, sortable: false}

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
        order: [[ 4, "desc" ]],
        ajax: function(data, callback, settings) {
            orderSort = tableColumn[data.order[0].column].data;
            orderDir = data.order[0].dir;
            $.getJSON('{{ url('itemstatic/data') }}', {
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
                    content += '<button type="button" class="btn btn-delete btn-accent m-btn--pill btn-sm m-btn m-btn--custom" data-index="'+ index.row +'"><i class="m-nav__link-icon fa fa-trash"></i></button>';
                    return content;
                },
                targets : [15]
            },
            //dibawah ini untuk membulatkan angka pada colom unit cost target [17]
            {
                targets: 14,
                render: function (data, type, row) {
                    return parseFloat(data).toFixed(0).toLocaleString();
                }
            },

        ],
        drawCallback: function(e,response){
            $(".btn-edit").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();

                count_id = data.count_id;
                $("input[name=item_desc]").val(data.item_desc);
                $("input[name=uom]").val(data.uom);
                $("input[name=status]").val(data.status);
                $("input[name=item_type]").val(data.item_type);
                $("input[name=spq]").val(data.spq);
                $("input[name=moq]").val(data.moq);
                $("input[name=terms_carrier]").val(data.terms_carrier);
                $("input[name=ex_work_lt]").val(data.ex_work_lt);
                $("input[name=fob_lt]").val(data.fob_lt);
                $("input[name=trading_lt]").val(data.trading_lt);
                $("input[name=logistic_lt]").val(data.logistic_lt);
                $("input[name=customs_lt]").val(data.customs_lt);
                $("input[name=yield]").val(data.yield);
                $("input[name=safety_time]").val(data.safety_time);
                $("input[name=unit_cost]").val(data.unit_cost);
                $("input[name=poq]").val(data.poq);
                $("input[name=safety_stock]").val(data.safety_stock);
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

    $("#btnDownload").click(function(){
        var filter = $("#txtSearch").val();
        $.ajax({
            url: '{{ url('product') }}/export',
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
@endsection
