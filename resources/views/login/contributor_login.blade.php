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
    <h1>Đăng nhập</h1>
    <form name="contributor_login" action="{{ url('/contributor/login')}}" method="post">
      @csrf
      <div class="form-group">
          <label>Email address</label>
          <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
      </div>
      <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Password">
      </div>
      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember_me">
        <label class="form-check-label" for="exampleCheck1">Remember me</label>
      </div>
      <div>
        <a href="{{ url("/contributor/create")}}">Đăng kí người đóng góp</a>
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Login</button>
    </form>
</div>
</body>
</html>
