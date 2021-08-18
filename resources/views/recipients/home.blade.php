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
    <div style = "padding: 20px">
      <a href="{{ url("/contributor/infor")}}" class="btn btn-info">Thông tin tài khoản</a>
      <a style="float: right" href="{{ url("/contributor/logout")}}" class="btn btn-info">Logout</a>
    </div>
    <div class="list-group">
      <a href="{{ url("/recipients/register_category")}}" class="list-group-item list-group-item-action">Đăng kí danh mục muốn nhận đóng góp</a>
    </div>
    <div class="list-group">
      <a href="{{ url("/products/receive")}}" class="list-group-item list-group-item-action">Danh sách sản phẩm nhận đóng góp</a>
    </div>
  </div>
</body>
</html>
