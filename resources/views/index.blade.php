<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/app.css">
    <title>Document</title>
</head>
<body>
<h2>Header</h2>
<div>
    @php
        \App\Http\Controllers\Menu\MenuController::init();
    @endphp
</div>
<h2>Footer</h2>
<div style="margin-top: 20px;">
    @php
        \App\Http\Controllers\Menu\MenuController::init('footer');
    @endphp
</div>
</body>
</html>
