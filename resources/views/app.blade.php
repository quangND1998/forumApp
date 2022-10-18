<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="locale" content="{{ App::getLocale() }}" />
    <base href="{{ asset('') }}">
    <title>Forum</title>
    <link rel="stylesheet" type="text/css" href="backend/css/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="backend/css/font-awesome/6.0.0/css/all.min.css" />



     <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>

    @routes
    @inertiaHead

</head>

<body >
    @inertia
    <script src="backend/js/jquery.3.2.1.min.js"></script>
</body>
<style>
    .dark {
        margin: 0;
        line-height: inherit;
        height: 100%;
        background-color: #1a263f;;
        width: 100%;
        position: absolute;
    }
    .line-hr{
        opacity: 0.5;
    }
    .bg-blue{
        background-color: #1a263f;
    }
    .bg-blue-opacity{
        background-color: rgb(33, 49, 84);
    }
    .text-blue{
        /* color: rgb(33, 49, 84); */
        color: white;
    }
    .text-blue-gray{
     color: #c6ccd0;
    }
    .nav{
        box-shadow: 3px 0px;
    }
    .reply-bg{
        background-color: #213154;
        color: white !important;
    }
    .forum-comment{

    }
</style>
</html>
