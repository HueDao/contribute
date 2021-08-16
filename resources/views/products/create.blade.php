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
<form name="product" action="{{ url("/product/store")}}" method="post" enctype="mutipart/form-data">
  @csrf
  <div class="form-group">
    <label>Tên sản phẩm</label>
    <input type="text" class="form-control" id="product_name" name="product_name">
  </div>
  <div class="form-group">
    <label >Danh mục sản phẩm đóng góp:</label>
    <select name="category_id">
      <option>--Chọn danh mục--</option>
          @foreach ($categories as $category)
      <option value="{{ $category->id }}">{{ $category->category_name }}</option>
          @endforeach
    </select>
  </div>
  <div class="form-group">
    <label>Ảnh</label>
    <input type="text" class="form-control" id="product_image" name="product_image">
  </div>
  <div class="form-group">
    <label>Số lượng</label>
    <input type="text" class="form-control" id="product_quantity" name="product_quantity">
  </div>
  <div class="form-group">
    <label>Hạn sử dụng</label>
    <input type="text" class="form-control" id="product_enpiry" name="product_enpiry">
  </div>
  <div class="form-group">
    <label>Mô tả</label>
    <input type="text" class="form-control" id="product_desc">
  </div>
  <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
</form>
</div>
</body>
</html>
