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
  <h2>Danh mục sản phẩm cần đóng góp</h2>   
  <div class="list-group">
  @if(isset($categories) && !empty($categories))
    @foreach ($categories as $c)
      <a href="{{ url("/recipients/list/$c->id")}}" class="list-group-item list-group-item-action">{{ $c->category_name }}</a>
    @endforeach
  @else
    Chưa có bản ghi nào trong bảng này
  @endif
  </div>
</div>
</body>
</html>
