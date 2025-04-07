<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Individual de Asistencias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 40px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .text-center {
            text-align: center;
        }
        .datos-principal {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .datos-principal table {
            width: 100%;
        }
        .datos-principal td {
            padding: 4px 8px;
        }
        .asistencia-table {
            width: 100%;
            border-collapse: collapse;
        }
        .asistencia-table th,

        .asistencia-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        .asistencia-table th {
            background-color: #eaeaea;
        }
        .footer {
            position: fixed;
            bottom: 30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }


        .container {
            width: 110%;
            border-collapse: collapse;
        }
        .container td {
            vertical-align: middle;
            text-align: center;
        }
        .header-image {
            width: 60px;
        }
        .header-image-right {
            width: 100px;
        }
        .text-center {
            text-align: center;
        }
        .underline {
            text-decoration: underline;
        }
        .left-image-cell {
            width: 100%; 
        }



    </style>
</head>
<body>

 
    <table class="container">
        <tr>
            <td><img src="{{'imagen/COA_Puno (1).png'}}" class="header-image" align="right"></td>
            <td>
                <h2 class="text-center">                 MUNICIPALIDAD PROVINCIAL DE PUNO</h2>
                <h3 class="text-center">GERENCIA DE ADMINISTRACIÓN</h3>
                <h4 class="text-center">SUB GERENCIA DE PERSONAL</h4>
            </td>
            <td><img src="{{'imagen/OTI_logo.png'}}" class="header-image-right" align="left"></td>
        </tr>
    </table>
       
    </div>
    <p class="text-center"><em>"Año de la recuperación y consolidación de la economía peruana"</em></p>
    <hr>

    <h4 class="text-center" style="text-decoration: underline;">HOJA DE CONTROL DE ASISTENCIA DE PRACTICANTE - 2025</h4>


    <div class="datos-principal">
        <table>
            <tr>
                <td><strong>NOMBRES Y APELLIDOS:</strong></td>
                <td>{{ $intern->name }} {{ $intern->lastname }}</td>
            </tr>
            <tr>
                <td><strong>OFICINA DESIGNADA:</strong></td>
                <td>Oficina de Tecnología Informática</td>
            </tr>
            <tr>
                <td><strong>CARRERA PROFESIONAL:</strong></td>
                <td>Ingeniería de Sistemas</td>
            </tr>
            <tr>
                <td><strong>FECHA DE INICIO:</strong></td>
                <td>{{ $intern->start_date }}</td>
            </tr>
            <tr>
                <td><strong>FECHA DE TÉRMINO:</strong></td>
                <td>{{ $intern->end_date }}</td>
            </tr>
        </table>
    </div>

    <table class="asistencia-table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Fecha</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>¿Asistió?</th>
                <th>O.B.S</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row['date'] }}</td>
                    <td>{{ $row['check_in'] }}</td>
                    <td>{{ $row['check_out'] }}</td>
                    <td>{{ $row['status'] }}</td>
                    <td></td>
                </tr>
            @endforeach
            @for ($i = count($reportData); $i < 30; $i++)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td colspan="5">&nbsp;</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Puno renace</strong> | Jr. Deustua N° 453 Plaza Mayor | Teléfono: (051) 601000 | www.munipuno.gob.pe</p>
    </div>

</body>
</html>
