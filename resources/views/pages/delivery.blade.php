@section('pageTitle', 'Delivery Order')

@extends("layouts/app")

@section('content')
<link rel="stylesheet" type="text/css" href="css/tablesignaturestyle.css">
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
                                        <th rowspan="2" style="text-align: left;">#</th>
                                        <th rowspan="2" style="text-align: left;">ETD</th>
                                        <th rowspan="2" style="text-align: left;">Address</th>
                                        <th rowspan="2" style="text-align: left;">Customer Name</th>
                                        <th rowspan="2" style="text-align: left;">Surat Jalan</th>
                                        <th rowspan="2" style="text-align: left;">Party Name</th>
                                        <th colspan="3" style="text-align: center;">Preparation</th>
                                        <th colspan="3" style="text-align: center;">Loading</th>
                                        <th rowspan="2" style="text-align: left;">Delivery Status</th>
                                        <th rowspan="2">&nbsp;</th>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>By</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>By</th>
                                    </tr>
                                </thead>
                                
                            </table>

                            <table id="tableSignature" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Picker</th>
                                        <th>Loading</th>
                                        <th>Logistic</th>
                                        <th>Truck</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tbody>
                            </table>
                            <!--<tbody></tbody>-->
                            <table id="export-table" style="display: none;">
                            <thead>
                                 <tr>
                                        <th>#</th>
                                        <th>Surat Jalan</th>
                                        <th>Order Item</th>
                                        <th>Party Name</th>
                                        <th>Destination</th>
                                        <th>Quantity</th>
                                        <th>&nbsp;</th>
                                </tr>
                            </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalForm" class="modal" role="dialog" aria-hidden="true">
<div class="modal-dialog" style="max-width: 50%; max-height:20%; " role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">@yield('pageTitle') Detail Item</h5>
        <a href="#"><i class="m-nav__link-icon fa fa-close" data-dismiss="modal" aria-label="Close"></i></a>
    </div>
    <form class="form-horizontal" id="formData">
        <div class="modal-body">

    
            <table class="center">
                <tr>
                    <td id="inputleft" >DO Number</td> <td id="outerleft"><input type="text" class="form-control" name="surat_jalan" required="" readonly></td>
                    <td id="inputleft">Customer Name</td> <td id="outerleft"><input type="text" class="form-control" name="customer_name" required="" readonly></td>
                </tr>

                <tr>
                    <td id="inputleft">Address</td> <td id="outerleft"><input type="text" class="form-control" name="address" required="" readonly></td>
                    <td id="inputleft">City</td> <td id="outerleft"><input type="text" class="form-control" name="city" required="" readonly></td>
                </tr>

                <tr>
                    <td id="inputleft">Delivery Date</td> <td id="outerleft"><input type="text" class="form-control" name="delivery_date" required="" readonly></td>
                    <td id="inputleft">Truck Identification</td> <td id="outerleft"><input type="text" class="form-control" name="truk_identification" required="" readonly></td>
                </tr>
                <tr>
                    <td id="inputleft">Nopol</td><td id="outerleft"><input type="text" class="form-control" name="nopol" required="" readonly></td>
                    <td id="inputleft">Driver Name</td> <td id="outerleft"><input type="text" class="form-control" name="driver_name" readonly></td>
                </tr>
                <tr>
                    <td id="inputleft">Phone Number</td><td id="outerleft"><input type="text" class="form-control" name="phone_number" readonly></td>
                </tr>
            </table>

            <div class="table-responsive">
                <table id="tableDetail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                           <th>#</th>
                           <th>Item Code</th>
                           <th>Item Name</th>
                           <th>QTY</th>
                           <th>UM</th>
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
    var delivery_id = '';
    var surat_jalan = '';

    $("#btnAdd").click(function(){
        delivery_id='';
        $("input[name=delivery_code").val('');
        $("input[name=delivery_time").val('');
        $("input[name=delivery_expedition").val('');
        $("input[name=delivery_destination").val('');
        $("input[name=delivery_city").val('');
        $('#modalForm').modal('show');
    });

    var tableColumn = [
        { data: "surat_jalan", width : 40, sortable: false },
        { data: "schedule_shipdate" },
        { data: "address" },
        { data: "address" },
        { data: "surat_jalan" },
        { data: "party_name" },
        { data: "ship_quantity_check" },
        { data: "schedule_shipdate" },
        { data: "ship_quantity_check" },
        { data: "ship_quantity_check" },
        { data: "schedule_shipdate" },
        { data: "ship_quantity_check" },
        { data: "ship_quantity_check" },//DeliveryStatus
        { data: "surat_jalan", width: 100, sortable: false}

    ];

    var tableSign = [
        { data: ""},
        { data: ""},
        { data: ""},
        { data: ""},
        { data: ""}

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

    var surat_jalan = '';

    var tableColumnDetail1 = [
        { data: "surat_jalan", width : 40, sortable: false},
        { data: "order_item" },
        { data: "order_item" },
        { data: "ship_quantity" },
        { data: "address" }
        
        
    ];
    var tableDetail1 = $("#tableDetail1").DataTable({
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
            $.getJSON('{{ url('delivery/detail') }}', {
                draw: data.draw,
                surat_jalan: surat_jalan,
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
        columns: tableColumnDetail1,
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

    function format ( d, data, callback, settings ) {
    // `d` is the original data object for the row
    $.getJSON('{{ url('delivery/detail') }}', {
                draw: data.draw,
                surat_jalan: surat_jalan,
                pageLength: 10,
                filter: $("#txtSearch").val()
            }, function(res) {
                callback({
                    recordsTotal: res.recordsTotal,
                    recordsFiltered: res.recordsFiltered,
                    data: res.listData
                });
            });

    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Full name:</td>'+
            '<td>'+d.code_truck+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Quantity:</td>'+
            '<td>'+d.surat_jalan+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Quantity:</td>'+
            '<td>'+d.order_item+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Quantity:</td>'+
            '<td>'+d.ship_quantity+'</td>'+
        '</tr>'+
    '</table>';
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


    function getBase64Image(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    return canvas.toDataURL("image/png");
    };

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
                               filename: function(){
                                    var d = new Date();
                                    var n = d.getTime();
                                    return 'Orbit Delivery Order' + " " + d;
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
                                    return 'Orbit Delivery Order' + " " + d;
                                }
                           },
                           {
                               "extend": 'pdf',
                               "text": '<i class="fa fa-file-pdf-o" style="color: green;"></i>',
                               "titleAttr": 'PDF',                               
                               "action": newexportaction,
                               orientation: 'landscape',
                               customize: function ( doc ) {

                                    doc.content[1].table.widths = 
                                    Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                    // Splice the image in after the header, but before the table
                                    doc.content.push( {
                                        margin: [ 0, 330, -250, 12 ],
                                        alignment: 'center',
                                        image: 'data:image/png;base64,<?php $im = file_get_contents('images/signature.jpg'); $imdata = base64_encode($im); echo $imdata;?>'
                                    } );
                                    // Data URL generated by http://dataurl.net/#dataurlmaker
                                },
                               exportOptions: 
                               {
                                columns: [0, 1, 2, 3, 4, 5]
                               }
                           },
                           {
                                "extend": 'print',
                                "text": '<i class="fa fa-print" style="color: green;"></i>',
                                /*customize: function ( doc ) {
                                    doc.content.push( {
                                        margin: [ 0, 0, 0, 12 ],
                                        alignment: 'center',
                                      image: 'images/logo.png'  
                                    } );
                                    console.log(doc.content)
                                },*/

                                

                                "titleAttr": 'Print',                                
                                "action": newexportaction,
                                customize: function(win)
                                    {
                         
                                        var last = null;
                                        var current = null;
                                        var bod = [];
                         
                                        var css = '@page { size: landscape; }',
                                            head = win.document.head || win.document.getElementsByTagName('head')[0],
                                            style = win.document.createElement('style');
                         
                                        style.type = 'text/css';
                                        style.media = 'print';
                         
                                        if (style.styleSheet)
                                        {
                                          style.styleSheet.cssText = css;
                                        }
                                        else
                                        {
                                          style.appendChild(win.document.createTextNode(css));
                                        }
                            
                                        head.appendChild(style);
                                 },
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                                },
                               filename: function(){
                                    var d = new Date();
                                    var n = d.getTime();
                                    return 'Orbit Delivery Order' + " " + d;
                                }
                                /*customize: function(doc){

                                    //ensure doc.images exists
                                    doc.images = doc.images || {};

                                    //build dictionary
                                    doc.images['myGlyph'] = getBase64Image(myGlyph);
                                    //..add more images[xyz]=anotherDataUrl here

                                    //when the content is <img src="myglyph.png">
                                    //remove the text node and insert an image node
                                    for (var i=1;i<doc.content[1].table.body.length;i++) {
                                        if (doc.content[1].table.body[i][0].text == '<img src="myglyph.png">') {
                                            delete doc.content[1].table.body[i][0].text;
                                            doc.content[1].table.body[i][0].image = 'myGlyph';
                                        }
                                    }
                                },*/

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
            $.getJSON('{{ url('delivery/data') }}', {
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
                targets : [13]
            },
        ],
        /*$('#tableData tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
         
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format(row.data()) ).show();
                        tr.addClass('shown');
                    }
        });*/
        drawCallback: function(e,response){
            $(".btn-edit").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();
                surat_jalan = data.surat_jalan;
                $("input[name=surat_jalan]").val(data.surat_jalan);
                $("input[name=customer_name]").val(data.address);
                $("input[name=address]").val(data.address);
                $("input[name=city]").val(data.address);
                $("input[name=delivery_date]").val(data.schedule_shipdate);
                $("input[name=truk_identification]").val(data.ship_quantity_check);
                $("input[name=nopol]").val(data.ship_quantity_check);
                $("input[name=driver_name]").val(data.ship_quantity_check);
                $("input[name=phone_number]").val(data.ship_quantity_check);
                tableDetail.ajax.reload();
                $('#modalForm').modal('show');
            });
            $(".btn-delete").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();

                swal.fire({
                    title: "Delete "+ data.delivery_code +" ?",
                    type: "question",
                    showCancelButton : true,
                    focusCancel : true,
                    dangerMode: true,
                    closeOnClickOutside : false
                })
                .then((confirm) => {
                    if (confirm.value) {
                        $.ajax({
                            url: '{{ url('delivery') }}/delete/' + data.delivery_id,
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

    var tableColumnDetail = [
        { data: "surat_jalan", width : 40, sortable: false},
        { data: "order_item" },
        { data: "order_item" },
        { data: "ship_quantity" },
        { data: "address" }
        
        
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
            $.getJSON('{{ url('delivery/detail') }}', {
                draw: data.draw,
                surat_jalan: surat_jalan,
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


    $('#tableData tbody').on('click', 'td:first-child', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );

      if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });

    $("#delivery_warehouse_id").select2({
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
                }else{
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
            url: '{{ url('delivery') }}' + (delivery_id ? '/' + delivery_id : ''),
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

    
});
</script>

<script type="text/javascript">
    function generateExcel(el) {
    var clon = el.clone();
    var html = clon.wrap('<div>').parent().html();

    //add more symbols if needed...
    while (html.indexOf('á') != -1) html = html.replace(/á/g, '&aacute;');
    while (html.indexOf('é') != -1) html = html.replace(/é/g, '&eacute;');
    while (html.indexOf('í') != -1) html = html.replace(/í/g, '&iacute;');
    while (html.indexOf('ó') != -1) html = html.replace(/ó/g, '&oacute;');
    while (html.indexOf('ú') != -1) html = html.replace(/ú/g, '&uacute;');
    while (html.indexOf('º') != -1) html = html.replace(/º/g, '&ordm;');
    html = html.replace(/<td>/g, "<td>&nbsp;");

    window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
}
$("#btnDownload").click(function (event) {
    generateExcel($("#tableData"));
});
</script>

<script type="text/javascript">
    
        $('#tableData').on('click', 'tbody td', function () {

        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            var data = row.data();

            row.child( format(data) ).show();
            tr.addClass('shown');
        }
        });

</script>


<script type="text/javascript" src="js/datetime.js"></script>
    <script type="text/javascript" src="js/jszip.min.js"></script>
    <script type="text/javascript" src="js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="js/buttons.html5.js"></script>
    <script type="text/javascript" src="js/buttons.print.min.js"></script>
    <script type="text/javascript" src="js/pdfmake.min.js"></script>
    <script type="text/javascript" src="js/vfs_fonts.js"></script>
    <script type="text/javascript" src="js/dataTables.select.min.js"></script>
@endsection
