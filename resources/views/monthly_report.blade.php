<!-- resources/views/monthly-report.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Water Billing Report</title>
    <!-- Include the CSS file compiled by Laravel Mix -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <!-- This is where the Vue component will be rendered -->
        <monthly-report></monthly-report>
    </div>

    <!-- Include the JS file compiled by Laravel Mix -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
