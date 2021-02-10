<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="title" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <link rel="stylesheet" href="{!! mix('css/app.css') !!}">
    <link rel="shortcut icon" href="{!! settings('favicon') !!}" type="image/x-icon">
    <link rel="icon" href="{!! settings('favicon') !!}" type="image/x-icon">
    @routes
    <script src="/js/localization.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{!! mix('js/app.js') !!}" defer></script>
</head>
<body class="flex flex-col min-h-screen h-screen font-sans text-gray-800">
@inertia
</body>
</html>
