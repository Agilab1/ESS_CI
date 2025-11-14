
    function setVendor(obj) {
        var lifnr = $(obj).val();
        $.post(window.location.href,{'supp_id':supp_id,'action':'setVendor'},function(data){window.location = '../suppl/index.php';});
        
    }
    
    function closeWindow() {
        debugger;
        let wnd = open(location, '_self');
        wnd.close();
    }
    
    function openWindow(obj)
    {
        var pass_id = $(obj).val();
    	url='https://agilesaptech.com/scp/supplier/qrcd_pass.php?pass_id=' + pass_id;
    	window.open(url,"_blank","height=250,width=900, resizable=yes,left=300,top=300");
    }

  $(function () {
    $("#dtbl").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#dtbl_wrapper .col-md-6:eq(0)');
    
    function closeWindow() {
        window.close();
    }
    
    
    
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });