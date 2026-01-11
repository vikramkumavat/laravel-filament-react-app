<!DOCTYPE html>
<html>
<head>
    <title>Properties List</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1 style="text-align: center; margin-bottom: 20px;">
        {{ config('app.name') }} {{-- Site name from .env --}}
    </h1>

    <h2>Properties List</h2>
    <table>
        <thead>
            <tr>
                <th>Property&nbsp;Id</th>
                <th>Property Type</th>
                <th>Borrower Name</th>
                <th>Location</th>
                <th>Price</th>
                <th>Sq&nbsp;Ft</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($properties as $property)
                <tr>
                    <td>{{ "Property #".$property->id }}</td>
                    <td>{{ $property->type->name }}</td>
                    <td>{{ $property->owner_name }}</td>
                    <td>{{ $property->location }}</td>
                    <td>{{ $property->price }}</td>
                    <td>{{ $property->sq_ft }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
