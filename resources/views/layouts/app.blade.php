<!doctype html>
<html lang="my">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Love Calculator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #fff7f9; }
    .heart { color: #e83e8c; }
    .card { border-radius: 12px; box-shadow: 0 6px 18px rgba(232,62,140,0.08); }
    .progress { height: 20px; border-radius: 10px; overflow: hidden; }
    .form-label {
        font-family:Georgia, 'Times New Roman', Times, serif;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-light bg-white shadow-sm mb-3 fixed-top">
    <div class="container">
      <a class="navbar-brand" href="{{ url('loves.index') }}">
        <span class="heart" style="font-size: 30px;" >💞 Love Calculator 💞</span>
      </a>
    </div>
  </nav>

  <div class="container mt-5 pt-5">
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
