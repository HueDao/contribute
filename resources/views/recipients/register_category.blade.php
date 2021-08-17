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
  <h2>Đăng kí danh mục sản phẩm muốn nhận</h2>   
  <form name="register_category" action="{{ url("/recipients/save_register_category")}}" method="post">
    @csrf
    @foreach ($categories as $category)
    <div class="form-check">
    <!-- <input class="form-check-input" type="checkbox" value="{{ $category->id }}" name="category_id" id="defaultCheck1"> -->
    <input type="checkbox" value="{{$category->id}}" name="category_id[]">
    <label class="form-check-label" for="defaultCheck1">
      {{ $category->category_name }}
    </label>
    </div>
    @endforeach
    <button type="submit" class="btn btn-primary">Đăng kí danh mục sản phẩm nhận</button>
  </form>
</div>
</body>
</html>
