
function datatable(array){
  $("#example1").DataTable(options_export_file(array)).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
}
