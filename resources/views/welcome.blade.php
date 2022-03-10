<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>wms-admin</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
            <!-- 直で/csvlistにアクセスしても表示されない laravelのrouteになる -->
            <router-link to="/csvlist">CSV</router-link>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
