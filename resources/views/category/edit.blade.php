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
  <h2>Thêm sản phẩm đóng góp</h2>   
<br></br>
<form name="product" action="{{ url("/category/update/$category->id") }}" method="post" enctype="mutipart/form-data">
    @csrf
  <div class="form-group">
    <label>Tên sản phẩm đóng góp</label>
    <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $category->category_name}}">
  </div>
  <div class="form-group">
    <label>Ảnh</label>
    <input type="text" class="form-control" id="category_image" name="category_image" value="{{ $category->category_image}}">
  </div>
  <div class="form-group">
    <label>Mô tả</label>
    <input type="text" class="form-control" id="category_desc" value="{{ $category->category_desc}}">
  </div>
  <button type="submit" class="btn btn-primary">Cập nhật danh mục</button>
</form>
</div>
</body>
</html>
