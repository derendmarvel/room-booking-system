<!DOCTYPE html>
<html>
<head>
    <title>Bookings Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
        }

        th {
            background: #f0f0f0;
        }
    </style>
</head>
<body>

<h2>Bookings Report</h2>

<table>
    <thead>
        <tr>
            <th>Room</th>
            <th>Date</th>
            <th>Time</th>
            <th>User</th>
            <th>Role</th>
            <th>Status</th>
            <th>Purpose</th>
        </tr>
    </thead>

    <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->room->name }}</td>
                <td>{{ $booking->usage_date }}</td>
                <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                <td>{{ $booking->user->name }}</td>
                <td>{{ $booking->user->role }}</td>
                <td>{{ $booking->status }}</td>
                <td>{{ $booking->purpose }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>