<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Cashier System')</title>
    
  </head>
  <body>
      <nav>
         <a href="{{route('categories.index')}}">Kategori</a>
         <a href="{{route('menu.index')}}">Menu</a>
         <a href="{{route('orders.index')}}">Order</a>
      </nav>
      <main class="container my-4">
        @yield('content')
      </main
  </body>
</html>