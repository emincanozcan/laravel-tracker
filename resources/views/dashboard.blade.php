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
    <script>
        window.tracker = {
            lastActivities: "{{ route('tracker.last-activities')}}",
            activityStatistics: "{{ route('tracker.activity-statistics')}}",
        };
    </script>
</head>

<body class="bg-gray-100">
    <div id="app"></div>
    <script src="{{ asset("vendor/emincan/tracker/js/app.js") }}"></script>
</body>

</html>