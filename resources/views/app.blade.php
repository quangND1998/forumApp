<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="locale" content="{{ App::getLocale() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ asset('') }}">
    
    <link rel="stylesheet" type="text/css" href="backend/css/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="backend/css/font-awesome/6.0.0/css/all.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">

     <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>

    @routes
    @inertiaHead

</head>

<body >
    @inertia
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="./TW-ELEMENTS-PATH/dist/js/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

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
    {{--  .bg-blue{
        background-color: #1a263f;
    }
    .bg-blue-opacity{
        background-color: rgb(33, 49, 84);
    }  --}}
    {{--  .text-blue{
        /* color: rgb(33, 49, 84); */
        color: white;
    }
    .text-blue-gray{
     color: #c6ccd0;
    }
    .nav{
        box-shadow: 3px 0px;
    }  --}}
    {{--  .reply-bg{
        background-color: #213154;
        color: white !important;
    }  --}}
    {{--  .forum-comment{

    }  --}}
</style>
</html>
