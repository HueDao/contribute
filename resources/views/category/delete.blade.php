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
  <h2>Xóa sản phẩm đóng góp</h2>   
  <br></br>
  <form name="category" action="{{ url("/category/destroy/$category->id") }}" method="post">
    @csrf
    <div class="form-group">
        <label for="category_name">ID danh mục:</label>
        <p>{{ $category->id }}</p>
    </div>

    <div class="form-group">
        <label for="category_name">Tên danh mục:</label>
        <p>{{ $category->category_name }}</p>
    </div>
    <button type="submit" class="btn btn-danger">Xác nhận xóa sản phẩm</button>
  </form>
</div>
</body>
</html>
