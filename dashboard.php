<?php
session_start();
if(empty($_SESSION["authorize"])){
  header("Location: index.php");
}
?>
<?php
include 'header.php';
?>
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
.mspad a
{
  font-size: 80px;
}


</style>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <img class="logo" src="assets/img/Mlogo.png">
      <a class="navbar-brand" href="#">MileSCOPE®</a>
    </div>
  </div>
</nav>

<div class="mspad">
<div class="container">
<div class="row">
    <a href="practice.php" class="btn btn-block btn-success">Practice</a>
    <a href="milestone.php" class="btn btn-block btn-info">Milestone</a>
</div>
</div>
</div>
<?php
include 'footer.php';
?>