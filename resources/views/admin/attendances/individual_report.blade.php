<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Individual de Asistencias</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    {{-- <div style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
        <img src="{{ asset('storage/imagenes/Logo-Puno.png') }}" width="100">
        <img src="{{ asset('storage/imagenes/COA_Puno.png') }}" width="100">

    </div> --}}
    
    
    
    <div class="text-center mb-4" style="text-align: center;">
        
        <h2 class="text-xl font-bold">
         MUNICIPALIDAD PROVINCIAL DE PUNO
        </h2>
        <h3 class="text-lg">
         GERENCIA DE ADMINISTRACIÓN
        </h3>
        <h4 class="text-md">
         SUB GERENCIA DE PERSONAL
        </h4>
        {{-- <p class="italic">
         "Año de la recuperación y consolidación de la economía peruana"
        </p> --}}
        <hr>
        <h4 class="text-lg font-bold" style="text-decoration: underline;">
            HOJA DE CONTROL DE ASISTENCIA DE PRACTICANTE-2025
        </h4>
        
       </div>

       <p>
        <strong>
         NOMBRES Y APELLIDOS:
        </strong>
        {{ $intern->name }} {{ $intern->lastname }}
       </p>
       <p>
        <strong>
         OFICINA DESIGNADA:
        </strong>
        {{ $intern->institution }}
       </p>
       <p>
        <strong>
         CARRERA PROFESIONAL:
        </strong>
        Escuela Profesional de Ingeniería de Sistemas
       </p>
      
       <p>
        <strong>
         FECHA DE INICIO:
        </strong>
        {{ $intern->start_date }}
       </p>
       <p>
        <strong>
         FECHA DE TÉRMINO:
        </strong>
        {{ $intern->end_date }}
       </p>
      </div>
     </div>
    
    {{-- <h2 style="text-align: center;">Hoja de Control de Asistencias - {{ $intern->name }} {{ $intern->lastname }}</h2> --}}
    {{-- <p><strong>DNI:</strong> {{ $intern->dni }}</p>
    <p><strong>Institución:</strong> {{ $intern->institution }}</p>
    <p><strong>Periodo:</strong> {{ $intern->start_date }} - {{ $intern->end_date }}</p> --}}
    
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora entrada</th>
                <th>Hora salida</th>
                <th>Estado</th>
                <th>O.B.S</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $row)
                <tr>
                    <td>{{ $row['date'] }}</td>
                    <td>{{ $row['check_in'] }}</td>
                    <td>{{ $row['check_out'] }}</td>
                    <td>{{ $row['status'] }}</td>
                    <td></td> {{-- Aquí puedes agregar observaciones si lo necesitas --}}
                </tr>
            @endforeach
        </tbody>
    </table>
    
    
</body>
</html>
