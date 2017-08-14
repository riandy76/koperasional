function printRecord() {
  
  var gbagian = $("#vbagian").val();    
  gbagian = gbagian.trim();
  var from_date = $('#from_date').val();
    
    if(from_date != '')
      {
        $.post("../php/include/kas_operasional_print.php", 
        {
            pfrom_date:from_date,
            pbagian: gbagian
        }, function (data, status) {
        $("#printModal").modal('show');
        $(".modalPrintBody").html(data);
        });
      }else
      {
        alert("Please Select Date");
      }
}

// READ records
function readRecords() {    
  var gbagian = $("#vbagian").val();    
  gbagian = gbagian.trim();
  var from_date = $('#from_date').val();
    
      if(from_date != '')
      {
        $.post("../php/include/kas_operasional_get.php", 
        {
            pfrom_date:from_date,
            pbagian: gbagian
        }, function (data, status) {
        $(".records_content").html(data);
        });
      }else
      {
        alert("Please Select Date");
      }
}

//jika halaman sudah berhasil di load / di buka
$(document).ready(function() {
// READ records on page load
readRecords(); // calling function	
});
