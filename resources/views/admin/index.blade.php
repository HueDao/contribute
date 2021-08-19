<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

  <div class="container">
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Đóng góp</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="{{ url("/admin/index")}}">Home</a></li>
      <li><a href="{{ url("/admin/product")}}">Sản phẩm quyên góp</a></li>
      <li><a href="{{ url("/admin/admin")}}">Người quản lí</a></li>
      <li><a href="{{ url("/admin/contributor")}}">Người quyên góp</a></li>
      <li><a href="{{ url("/admin/recipient")}}">Người nhận quyên góp</a></li>
      <li><a href="{{ url("/admin/shipper")}}">Người vận chuyển</a></li>
      <li><a href="{{ url("/category/index")}}">Quản lí danh mục sản phẩm</a></li>
      <li><a href="{{ url("/contributor/infor")}}">Thông tin tài khoản</a><li>
    </ul>
  </div>
</nav>
<div>
      <a style="float: right; padding: 10px" href="{{ url("/logout")}}" class="btn btn-info">Logout</a>
    </div>
  </div>
</body>
</html>