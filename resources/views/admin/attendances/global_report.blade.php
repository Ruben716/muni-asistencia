<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Global de Asistencias</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
        <img src="{{'imagen/COA_Puno.png'}}" width="100" align="left" >
        <img src="{{'imagen/Logo-Puno-Renace.png'}}" width="200" align="right" >
        
    </div>
    <h2 style="text-align: center;">Reporte Global de Asistencias</h2>
    <br>
    <br>
    <br>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Tardanzas</th>
                <th>Asistencias</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $row)
                <tr>
                    <td>{{ $row['name'] }}</td>
                    <td>{{ $row['dni'] }}</td>
                    <td>{{ $row['tardanzas'] }}</td>
                    <td>{{ $row['asistencias'] }}</td>
                    <td>{{ $row['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
