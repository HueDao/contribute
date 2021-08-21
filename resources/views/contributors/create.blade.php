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
  <h2>Đăng kí người dùng</h2> 
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
    </div>
  @endif  
  <form name="category" action="{{ url("/contributor/store") }}" method="post">
      @csrf
      <div class="form-group">
        <label for="name">Tên:</label>
        <input type="text" name="name" class="form-control" id="name">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" class="form-control" id="email">
      </div>
      <div class="form-group">
        <label >Đối tượng đóng:</label>
        <select name="role">
        <option value="0">--Chọn đối tượng--</option>
            @foreach ($objects as $object)
        <option value="{{ $object->role }}">{{ $object->object_name }}</option>
            @endforeach
        </select>
        </div>
      <div class="form-group">
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" class="form-control" id="password">
      </div>

      <div class="form-group">
          <label for="password_confirmation">Nhập lại mật khẩu:</label>
          <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
      </div>
      <div class="form-group">
          <label>Số điện thoại</label>
          <input type="text" name="number_phone" class="form-control" id="number_phone">
      </div>
      <div class="form-group">
          <label>Địa chỉ</label>
          <input type="text" name="address" class="form-control" id="address">
      </div>
      <div class="form-group">
          <label for="desc">Mô tả</label>
          <textarea name="desc" class="form-control" rows="5" id="desc"></textarea>
      </div>
      <button type="submit" class="btn btn-info">Đăng kí</button>
    </form>
</div>
</body>
</html>
