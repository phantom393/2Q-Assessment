<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>2Q</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-900">
    <div style="font-size:12px">
        {{ $slot }}
    </div>
    @livewireScripts
    @vite('resources/js/app.js')
</body>
</html>
