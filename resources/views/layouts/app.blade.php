<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Test</title>
    @vite(['resources/css/app.css'])
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    @vite(['resources/js/app.js'])
</body>
</html>
