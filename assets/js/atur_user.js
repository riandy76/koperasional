// Add Record
function addRecord() {

var formData = new FormData($("form#data_baru")[0]);

    // get values
    var gnama_user = $("#vnama_user").val();
    gnama_user = gnama_user.trim();

    var gpassword = $("#vpassword").val();
    gpassword = gpassword.trim();

    var glevel = $("#vlevel").val();
    glevel = glevel.trim();

    var giduser = $("#vid_user").val();
    giduser = giduser.trim();
 
    if (gnama_user == "") {
        alert("Nama User tidak boleh kosong!");
    }
    else if (gpassword == "") {
        alert("Password tidak boleh kosong!");
    }
    else if (glevel == "") {
        alert("User Name tidak boleh kosong !");
    }
    else if (giduser == "") {
        alert("ID User tidak boleh kosong !");
    }       
    else {
            $.ajax({
                type: 'POST',
                url: '../php/user/user_create.php',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response, textStatus, jqXHR) {
                    // close the popup
                    $("#modalBaru").modal("hide");            
                    // clear fields from the popup
                    $("#vnama_user").val("");
                    $("#vpassword").val("");
                    $("#vlevel").val("");
                    // read records again
                    readRecords();
                }
            });
    }
}

/**
Fungsi Untuk Delete Record
**/
function detailsUser(vid) {

  // Open modal popup
  $("#modalUpdate").modal("show");
  $("#vid_user_update").val(vid);
    
$.post("../php/user/user_details.php", {
            pid: vid
        },
        function (data, status) {
            // PARSE json data
            var usr = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#vlevel_update").val(usr.user_name);
            $("#vnama_user_update").val(usr.nama);
            $("#vfoto_details").val(usr.pic);
        }
    );
}

// Update User
function updateUser() {
    // get values
var formData = new FormData($("form#data_update")[0]);

    var giduser = $("#vid_user_update").val();
    giduser = giduser.trim();

    var gnama_user = $("#vnama_user_update").val();
    gnama_user = gnama_user.trim();

    var gpassword = $("#vpassword_update").val();
    gpassword = gpassword.trim();

    var glevel = $("#vlevel_update").val();
    glevel = glevel.trim();
 
    if (gnama_user == "") {
        alert("Nama User tidak boleh kosong!");
    }
    else if (gpassword == "") {
        alert("Password tidak boleh kosong!");
    }
    else if (glevel == "") {
        alert("User Name tidak boleh kosong !");
    }     
    else {
            $.ajax({
                type: 'POST',
                url: '../php/user/user_update.php',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response, textStatus, jqXHR) {
                    // close the popup
                    $("#modalUpdate").modal("hide");
                    // read records again
                    $("#vpassword_update").val("");
                    readRecords();
                    setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                    }, 2000);
                }
            });
    }
}


/**
Fungsi Untuk Delete Record
**/
function deleteUser(vid) {
    $( "#dialog-confirm" ).dialog({
      dialogClass: "no-close",
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Delete": function() {
          // $( this ).dialog( "close" );
        $.post("../php/user/user_delete.php", {
                pid: vid
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();                
            }
        );
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });
}

// READ records
function readRecords() {
        $.post("../php/user/user_read.php", function (data, status) {
          $(".records_content").html(data);
        });
}


$(document).ready(function() {

    $('#icon').click(function(){

      if($('#vpassword').attr('type') == 'password'){
        $('#vpassword').attr('type','text');
        $('#icon').attr('class','fa fa-eye');
      }else{
        $('#vpassword').attr('type','password');
        $('#icon').attr('class','fa fa-eye-slash');
      }

    });

    $('#icon_update').click(function(){

      if($('#vpassword_update').attr('type') == 'password'){
        $('#vpassword_update').attr('type','text');
        $('#icon_update').attr('class','fa fa-eye');
      }else{
        $('#vpassword_update').attr('type','password');
        $('#icon_update').attr('class','fa fa-eye-slash');
      }

    });
// Baca data user
readRecords();
});