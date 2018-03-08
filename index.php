<?php
session_start();
if (! isset($_SESSION['ms_token'])) {
    $_SESSION['ms_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}

?>
<?php
include 'header.php';
?>
<style>
body {
  padding-top: 100px;
}
</style>
<div class="row">
<div class="container">
  <div class="col-sm-6">
    <img src="/assets/img/Mlogo.png">
</div>
<div class="col-sm-6">
	<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Access Panel</h3>
  </div>
  <div class="panel-body">
  	<div id="ms-message"></div>
     <form class="form-horizontal" id="ms-login">
    	<div class="form-group">
      <label for="InputUsername" class="col-lg-2 control-label">Username</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="InputUsername" placeholder="Enter Username" name="username">
      </div>
    </div>
    <div class="form-group">
      <label for="InputPassword" class="col-lg-2 control-label">Password</label>
      <div class="col-lg-10">
        <input type="password" class="form-control" id="InputPassword" placeholder="Enter Password" name="password">
      </div>
    </div>
    <button type="submit" class="btn btn-block btn-primary">Login</button>
    </form>
  </div>
</div>
</div>
</div>
</div> 

<?php
include 'footer.php';
?>