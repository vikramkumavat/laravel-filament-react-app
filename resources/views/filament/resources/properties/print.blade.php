<!DOCTYPE html>
<html>
<head>
    <title>Print Properties</title>
    <style>
        @media print {
            button { display: none; }
        }
    </style>
</head>
<body>
    <h1>Property List</h1>
    <button onclick="window.print()">Print</button>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Property Id</th>
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

{{-- <script>
    window.print();
</script> --}}