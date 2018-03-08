<?php
session_start();
if(empty($_SESSION["authorize"])){
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title> MILESCOPE | Accounts</title>
<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-+ENW/yibaokMnme+vBLnHMphUYxHs34h9lpdbSLuAwGkOKFRl4C34WkjazBtb7eT" crossorigin="anonymous">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<style type="text/css">
.logo
{
    height:55px;
    width:70px; 
    position:relative;
    top:4px;
    padding-left: 0;
    left:-195px;
}
.mspad
{
    padding-top:90px;

}
</style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <img class="logo" src="/assets/img/Mlogo.png">
      <a class="navbar-brand" href="#">MileSCOPE®</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li  class="active" ><a href="dashboard.php">Go back to Management</a></li>
      </ul>
      
    </div>
  </div>
</nav>
<div class="mspad container">
  <button type="button" id="radd" class="btn btn-primary btn-lg">Enroll Student</button><br><br>
    <div id="ms-message"></div>
    <table id="rusers" class="table table-bordered table-striped">
     <thead>
      <tr>
		<th>ID</th>
		<th>Firstname</th>
		<th>Lastname</th>
		<th>Age</th>
		<th>Gender</th>
		<th>Address</th>
		<th>Parents</th>
		<th width="11%">Action</th>
      </tr>
     </thead>
    </table>
  <div id="updateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Student</h4>
      </div>
      <div class="modal-body">
<form id="ms-update">
<div class="form-group">
  <input type="hidden" name="sid" class="form-control" id="sid">
  <label class="control-label" for="fname">Firstname</label>
  <input type="text" name="fname" class="form-control" id="fname">
</div>
<div class="form-group">
  <label class="control-label" for="lname">Lastname</label>
  <input type="text" name="lname" class="form-control" id="lname">
</div>

<div class="form-group">
  <label class="control-label" for="address">Address</label>
  <input type="text" name="address" class="form-control" id="address">
</div>
<button type="submit" class="btn btn-primary btn-block">Update Student</button>
</form>
      </div>
    </div>
  </div>
</div>


  <div id="deleteModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Student</h4>
      </div>
      <div class="modal-body">
<form id="ms-delete">
<input type="hidden" name="dsid" class="form-control" id="dsid">
<button type="submit" class="btn btn-danger btn-block">Confirm Delete Student</button>
</form>
      </div>
    </div>
  </div>
</div>

  <div id="addModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Enrollment Form</h4>
      </div>
      <div class="modal-body">
<form id="ms-add">
<div class="form-group">
  <label class="control-label" for="inputDefault">Firstname</label>
  <input type="text" name="fname" class="form-control" id="inputDefault">
</div>
<div class="form-group">
  <label class="control-label" for="inputDefault">Lastname</label>
  <input type="text" name="lname" class="form-control" id="inputDefault">
</div>

<div class="form-group">
  <label class="control-label" for="inputDefault">Gender</label>
  <select name="gender" class="form-control" id="inputDefault">
  <option value="Male">Male</option>
  <option value="Female">Female</option>
  </select>
</div>

<div class="form-group">
  <label class="control-label" for="inputDefault">Age</label>
  <input type="number" name="age" class="form-control" id="inputDefault" min="1">
</div>

<div class="form-group">
  <label class="control-label" for="inputDefault">Address</label>
  <input type="text" name="address" class="form-control" id="inputDefault">
</div>

<div class="form-group">
  <label class="control-label" for="inputDefault">Parents/Guardian</label>
  <input type="text" name="parents" class="form-control" id="inputDefault">
</div>

<div class="form-group">
  <label class="control-label" for="inputLarge">Note</label>
  <textarea name="note"  class="form-control" rows="3" id="inputLarge"></textarea>
</div>
<button type="submit" class="btn btn-primary btn-block">ADD</button>
</form>
      </div>
    </div>
  </div>
</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script>
window.token = { ms_token: "<?php echo $_SESSION['ms_token']; ?>" };
$(function() {
    $.ajaxSetup({
        cache: false,
        data: window.token
    });

    var enroll = $("#ms-enroll");
    var message = $("#ms-message");
    var rupdate = $("#rupdate");
    var rdelete = $("#rdelete");
    var raddmodal = $("#addModal");
    var rupdatemodal = $("#updateModal");
    var rdeletemodal = $("#deleteModal");
    var msTable = $("#rusers").DataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "main.Account.php",
            type: "POST"
        },
        "columnDefs": [{
            "targets": [0, 3, 4, 5, 6, 7],
            "orderable": false,
        }, ],
    });

    function toJson(form) {
        var array = $(form).serializeArray();
        var json = {};

        $.each(array, function() {
            json[this.name] = this.value || '';
        });

        return json;
    }

    function getInfo(sid) {
        $.post("main.Account.php", {
            "req": "info",
            "sid": sid
        }, function(data) {
            $.each(data, function(a, b) {
                $("#" + a).attr("value", b);
            })
        }, 'json')
    }

    function deleteUser(sid) {
        $("#dsid").attr("value", sid);
    }

    $("#ms-update").submit(function(e) {
        e.preventDefault();
        var data = toJson(this);
        $.post("main.Account.php", {
            "req": "update",
            "data": data
        }, function(response) {
            if (response) {
                message.html('<div class="alert alert-success">Updated Successfully</div>').hide().fadeIn();
                msTable.ajax.reload();
                rupdatemodal.modal('hide');
            }
        })
    });

    $("#ms-delete").submit(function(e) {
        e.preventDefault();
        var data = toJson(this);
        $.post("main.Account.php", {
            "req": "delete",
            "data": data
        }, function(response) {
            if (response) {
                message.html('<div class="alert alert-warning">Deleted Successfully</div>').hide().fadeIn();
                msTable.ajax.reload();
                rdeletemodal.modal('hide');
            }
        })
    });

    $("#ms-add").submit(function(e) {
        e.preventDefault();
        var data = toJson(this);
        $.post("main.Enroll.php", {
            "data": data
        }, function(response) {
            if (response == "success") {
                message.html('<div class="alert alert-success">Added Successfully.</div>').hide().fadeIn();
            } else {
                message.html('<div class="alert alert-warning">Somefields are Empty.</div>').hide().fadeIn();
            }
            $("#ms-add").each(function() {
                this.reset();
            });
            msTable.ajax.reload();
            raddmodal.modal('hide');
        })
    });

    $(document).on("click", "#radd", function() {
        message.hide();
        raddmodal.modal();
        deleteUser($(this).data("id"));
    });

    $(document).on("click", "#rupdate", function() {
        message.hide();
        rupdatemodal.modal();
        getInfo($(this).data("id"));
    });

    $(document).on("click", "#rdelete", function() {
        message.hide();
        rdeletemodal.modal();
        deleteUser($(this).data("id"));
    });

})
</script>
</body>
</html>