<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Styles -->
    @if (env('APP_ENV') === 'production')
        <link href="{{ config('app.url') }}/css/app.css?v={{ config('app.asset_version') }}" rel="stylesheet">
    @else
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    @endif

    <!-- Pass the per-page value from Laravel to React -->
    <script>
        window.AUCTION = {!! json_encode([
            'PER_PAGE' => env('AUCTION_PER_PAGE'),
            'APP_NAME' => env('APP_NAME'),
            'NOTIFICATION_MIN' => env('NOTIFICATION_MIN'),
            'NOTIFICATION_VISITED' => (request()->query('vn') == 1 ? true : null),
            'APP_URL' => config('app.url'),
        ]) !!};
    </script>

</head>

<body>
    <div id="app"></div> <!-- React app will be rendered here -->

    <!-- Scripts -->
    @if (env('APP_ENV') === 'production')
        <script src="{{ config('app.url') }}/js/app.js?v={{ config('app.asset_version') }}" defer></script>
    @else
        <script src="{{ mix('/js/app.js') }}" defer></script> <!-- Include compiled React JS file -->
    @endif
</body>

</html>
