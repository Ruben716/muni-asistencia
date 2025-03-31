<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h2 style="text-align: center;">{{ $title }}</h2>

    @foreach($attendances as $date => $dailyAttendances)
        <h3>{{ $filter == 'day' ? \Carbon\Carbon::parse($date)->format('d/m/Y') : $date }}</h3>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Practicante</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dailyAttendances as $attendance)
                    <tr>
                        <td>{{ $attendance->id }}</td>
                        <td>{{ $attendance->intern->name }}</td>
                        <td>{{ $attendance->check_in }}</td>
                        <td>{{ $attendance->check_out ?? 'No registrada' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

</body>
</html>
