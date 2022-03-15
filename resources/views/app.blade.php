<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <base href="{{ asset('') }}">
    <link rel="stylesheet" type="text/css" href="backend/css/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="backend/css/font-awesome/6.0.0/css/all.min.css" />
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>

    @routes
    @inertiaHead

</head>

<body>
    @inertia
</body>

</html>
