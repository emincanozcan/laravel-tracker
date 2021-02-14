<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tracker{{ config('app.name') ? ' - ' . config('app.name') : '' }}</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("vendor/emincan/tracker/css/app.css") }}">
</head>
<body class="bg-gray-100">
<div id="app"></div>
{{--<header class=" w-full bg-gray-900 py-4">--}}
{{--    <div class="mx-auto max-w-5xl flex">--}}
{{--        <h1 class="text-2xl text-white font-medium">Tracker</h1>--}}
{{--    </div>--}}
{{--</header>--}}
{{--<main class="max-w-5xl mx-auto mt-8 bg-white rounded shadow-lg py-8 px-8">--}}
{{--    <h2 class="pb-2 border-b-2 border-gray-100 font-medium">Last Activities</h2>--}}
{{--    @foreach($activityData as $activity)--}}
{{--        <div class="">--}}
{{--            {{ "test" }}--}}
{{--        </div>--}}
{{--    @endforeach--}}
{{--</main>--}}
<script src="{{ asset("vendor/emincan/tracker/js/app.js") }}"></script>
</body>
</html>
