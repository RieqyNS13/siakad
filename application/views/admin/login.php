<html>
<head>
<link rel="stylesheet" href="<?php echo base_url()."/assets/bootstrap/css/bootstrap.min.css"; ?>">
<script type="text/javascript" src="<?php echo base_url()."/assets/jquery-1.11.2.min.js"; ?>"></script>
<title>Admin Login</title>
<style type="text/css">
table{
border:1px #000 solid;
padding:5px;
font-family:Calibri;
font-size:15px;
}
body{
font-family:Calibri;
font-size:17px;
padding:5px;
}
input{
border:1px #000 solid;
padding:0px;
font-family:Calibri;
font-size:15px;
}
</style>
</head>
<body>
<br>
<div class="container">
<div class="row">
<div class="col-sm-5 col-sm-offset-3">
<div class="panel panel-primary">
<div class="panel-heading">Login Administrator | Tata Usaha | Kurikulum | Guru</div>
  <div class="panel-body">
  <form action="<?php echo site_url()."/admin/login/ceklogin"; ?>" method="post">
  <div class="form-group">
    <label>Username</label>
    <input type="text" class="form-control" name="user" placeholder="Username" required>
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" name="pass" placeholder="Password" required>
  </div>
  <div class="form-group">
    <label>Type</label>
    <select name="type" class="form-control">
	<option value="admin">Admin</option>
	<option value="tatausaha">Tata Usaha</option>
	<option value="kurikulum">Kurikulum</option>
	<option value="guru">Guru</option>
	</select>
  </div>
      <button type="submit" class="btn btn-primary" name="btn">Login</button>
</form>
  
  </div>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-5 col-sm-offset-3">
<?php echo $status; ?>
</div>
</div>
</div>
</body>
</html>