$('#btnDownload').on('click', function() {
          var data = $('#tableData').DataTable().table().data();
          $.merge( data, $('#tableSignature').DataTable().table().data() );
          $('#export-table').DataTable({
            dom: 'B',
            data: data,
            buttons: [{
              extend: 'pdfHtml5'
            }],
            drawCallback: function() {
              $('#export-table_wrapper .buttons-pdf').click()
               setTimeout(function() {
                  $('#export-table').DataTable().destroy(false);
               }, 200)
            }
          })
        })