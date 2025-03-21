<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
    @vite(['resources/css/app.css'])
</head>

<body class="antialiased dark:bg-black {{session('darkMode') ? 'dark' : 'no-dark'}} " id="light-dak-mode">
    {{$slot}}
</body>

</html>