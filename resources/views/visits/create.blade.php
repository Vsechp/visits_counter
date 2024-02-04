<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Visit</title>
</head>
<body>
<h1>Record Visit</h1>

<form method="POST" action="{{ route('visits.store') }}">
    @csrf
    <label for="ip">IP Address:</label>
    <input type="text" name="ip" required>

    <label for="city">City:</label>
    <input type="text" name="city" required>

    <label for="device">Device:</label>
    <input type="text" name="device" required>

    <button type="submit">Record Visit</button>
</form>
</body>
</html>
