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
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form name="product" action="{{ url("/product/store")}}" method="post" enctype="mutipart/form-data">
  @csrf
  <div class="form-group">
    <label>Tên sản phẩm</label>
    <input type="text" class="form-control" id="product_name" name="product_name">
  </div>
  <div class="form-group">
    <label >Danh mục sản phẩm đóng góp:</label>
    <select name="category_id">
      <option value="">--Chọn danh mục--</option>
          @foreach ($categories as $category)
      <option value="{{ $category->id }}">{{ $category->category_name }}</option>
          @endforeach
    </select>
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
    <textarea class="form-control" id="product_desc" name="product_desc"></textarea>
  </div>
  <div class="form-group">
    <label>Ngày có thể quyên góp</label>
    <input type="text" class="form-control" id="date_contribute" name="date_contribute">
  </div>
  <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
</form>
</div>
</body>
</html>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#product_enpiry" ).datepicker({ dateFormat: 'dd/mm/yy' });
  } );
  $( function() {
    $( "#date_contribute" ).datepicker({ dateFormat: 'dd/mm/yy' });
  } );
  </script>

