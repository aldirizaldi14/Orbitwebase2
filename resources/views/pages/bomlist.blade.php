@section('pageTitle', 'Bomlist')
@extends("layouts/app")
@section('content')

<link rel="stylesheet" type="text/css" href="css/btnexpbomlist.css">

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
                                <div id="buttonexportbomlist" class="col-md-6 col-sm-11">
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
                                        <th>Finished Good</th>
                                        <th>Desc</th>
                                        <th>Child Item</th>
                                        <th>Desc</th>
                                        <th>Effective Date</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                            </table>
                            <tbody>
                            </tbody>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalForm" class="modal" role="dialog" aria-hidden="true">
<div class="modal-dialog" style="max-width: 65%; max-height:45%; " role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">@yield('pageTitle') Detail Item</h5>
        <a href="#"><i class="m-nav__link-icon fa fa-close" data-dismiss="modal" aria-label="Close"></i></a>
    </div>
    <form class="form-horizontal" id="formData">
        <div class="modal-body">

            <div class="table-responsive">
                <table id="tableDetail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Top Item</th>
                            <th>Level</th>
                            <th>Parent Item</th>
                            <th>Parent Desc</th>
                            <th>Completion Subinv</th>
                            <th>Child Item</th>
                            <th>Child Item Type</th>
                            <th>UOM</th>
                            <th>Usage</th>
                            <th>Extended Usage</th>
                            <th>Effc.Date Form</th>
                            <th>Subtitute Item</th>
                        </tr>
                    </thead>
                </table>
                <tbody></tbody>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    var p_item = '';

    $("#btnAdd").click(function(){
        p_item='';
        $('#modalForm').modal('show');
    });

    var tableColumn = [
        { data: "p_item", width : 50, sortable: false},
        { data: "p_item" },
        { data: "p_item_desc" },
        { data: "c_item" },
        { data: "c_item_desc" },
        { data: "effective_date_to" },
        { data: "p_item", width: 100, sortable: false}
    ];


    var table = $("#tableData").DataTable({
        dom : 'lrtip',
        deferRender: true,
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
            $.getJSON('{{ url('bomlist/data') }}', {
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
                    content = '<button type="button" class="btn btn-edit btn-accent m-btn--pill btn-sm m-btn m-btn--custom" data-index="'+ index.row +'"><i class="m-nav__link-icon fa fa-file"></i></button>';
                    content += '<button type="button" class="btn btn-delete btn-accent m-btn--pill btn-sm m-btn m-btn--custom" data-index="'+ index.row +'"><i class="m-nav__link-icon fa fa-trash"></i></button>';
                    return content;
                },
                targets : [6]
            },
        ],
        drawCallback: function(e,response){
            $(".btn-edit").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();
                p_item = data.p_item;
                p_item = data.p_item;
                tableDetail.ajax.reload();
                $('#modalForm').modal('show');
            });
            $(".btn-delete").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();

                swal.fire({
                    title: "Delete "+ data.receipt_code +" ?",
                    type: "question",
                    showCancelButton : true,
                    focusCancel : true,
                    dangerMode: true,
                    closeOnClickOutside : false
                })
                .then((confirm) => {
                    if (confirm.value) {
                        $.ajax({
                            url: '{{ url('bomlist') }}/delete/' + data.p_item,
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

    var buttons = new $.fn.dataTable.Buttons(table, {
        "buttons": [

        ]
    }).container().appendTo($('#buttonexportbomlist'));


    var tableColumnDetail = [
        { data: "p_item", width : 50, sortable: false},
        { data: "Top_item" },
        { data: "Level_" },
        { data: "Parent_item" },
        { data: "Parent_description" },
        { data: "Completion_subinv" },
        { data: "Child_item" },
        { data: "Child_item_type" },
        { data: "Uom" },
        { data: "Usage" , render: $.fn.dataTable.render.number(",", ".", 2)},
        { data: "Extended_usage" , render: $.fn.dataTable.render.number(",", ".", 2)},
        { data: "Effectivity_date_from"},
        { data: "Substitute_Item" }

    ];
    var tableDetail = $("#tableDetail").DataTable({

        deferRender: true,
        filter : false,
        sortable: false,
        scrollY: 280,
        scrollX: true,
        info: true,
        paging: false,
        processing: true,
        serverSide: true,
        ordering : true,
        order: [[ 1, "asc" ]],
        ajax: function(data, callback, settings) {
            $.getJSON('{{ url('bomlist/detail') }}', {
                draw: data.draw,
                p_item: p_item,
                pageLength: 10,
                filter: $("#txtSearch").val()
            }, function(res) {
                callback({
                    recordsTotal: res.recordsTotal,
                    recordsFiltered: res.recordsFiltered,
                    data: res.listData
                });
            });
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
        ]
    });

    $("#txtSearch").typeWatch({
        callback: function (value) { table.ajax.reload(); },
        wait: 750,
        highlight: true,
        allowSubmit: false,
        captureLength: 2
    });
});
</script>
@endsection
