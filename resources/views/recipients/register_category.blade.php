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
    <a style="float: right" href="{{ url("/logout")}}" class="btn btn-info">Logout</a>
  </div>
  <h2>Đăng kí danh mục sản phẩm muốn nhận</h2>
  @if (session('infor'))
        <div class="alert alert-success">
            {{ session('infor') }}
        </div>
  @endif
  @if(isset($note))
    <div class="alert alert-danger">
        {{ $note }}
    </div>
  @endif
  <form name="register_category" action="{{ url("/recipients/save_register_category")}}" method="post">
    @csrf
    @foreach ($categories as $category)
    <div class="form-check" class="list-group-item list-group-item-action">
    <input type="checkbox" value="{{$category->id}}" name="category_id[]">
    <label class="form-check-label" for="defaultCheck1">
      {{ $category->category_name }}
    </label>
    </div>
    @endforeach
    <button type="submit" class="btn btn-primary">Đăng kí danh mục sản phẩm nhận</button>
  </form>
  <h2>Danh mục sản phẩm đã đăng kí</h2>
  <form name="delete_register_category" action="{{ url("/delete/categoryRegister")}}" method="post">
  @csrf
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>STT</th>
        <th>Tên danh mục </th>
        <th>Xóa danh mục</th>
      </tr>
    </thead>
    <tbody>
      @if(isset($categories_registered) && !empty($categories_registered))
        @foreach ($categories_registered as $c)
          <tr>
            <td>{{ ++$stt }}</td>
            <td>{{ $c->category_name }}</td>
            <td>
            <input type="checkbox" value="{{$c->id}}" name="category_user_id[]">
            </td>
          </tr>
        @endforeach
      @else
      <div class="alert alert-danger">
        Chưa có bản ghi nào trong bảng này
      </div>
      @endif
    </tbody>
  </table>
  <div style = "padding: 20px">
    <button type="submit" class="btn btn-danger">Xóa danh mục đăng kí nhận sản phẩm</button>
    <a style="float: right" href="{{ url("/recipients/home")}}" class="btn btn-primary">Back</a>
  </div>
  </form>
</div>
</body>
</html>
