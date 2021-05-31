<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>


    </head>
    <body>
      <h1>{{$details['title']}}</h1>
      <p>Email: {{$details['email']}}</p>
      <p>Password: {{$details['password']}}</p>

    </body>
</html>
