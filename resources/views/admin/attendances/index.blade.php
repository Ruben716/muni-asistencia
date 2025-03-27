<x-layouts.app :title="__('Practicantes')">
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Registrar Asistencia</h2>
        
        <!-- Mostrar mensajes de éxito o error -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-2 mb-4">{{ session('success') }}</div>
        @elseif($errors->any())
            <div class="bg-red-500 text-white p-2 mb-4">{{ $errors->first() }}</div>
        @endif

        <!-- Formulario para ingresar el DNI -->
        <form action="{{ route('attendances.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <input 
                    type="text" 
                    name="dni" 
                    placeholder="Ingrese DNI" 
                    maxlength="8"
                    class="w-full p-2 border rounded-md"
                    pattern="\d{8}"
                    inputmode="numeric"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">Registrar Asistencia</button>
        </form>

        <!-- Filtro para elegir el periodo (Hoy, Esta Semana, Este Mes) -->
        <!-- Agregado para permitir que el usuario seleccione el filtro -->
        <form action="{{ route('attendances.index') }}" method="GET" class="mb-4">
            <select name="filter" onchange="this.form.submit()" class="p-2 border rounded-md">
                <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hoy</option>
                <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Esta Semana</option>
                <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Este Mes</option>
            </select>
        </form>

        <!-- Tabla de Asistencias -->
        <div class="mt-4 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
                <thead class="bg-gray-200 dark:bg-gray-700">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Practicante</th>
                        <th class="border border-gray-300 px-4 py-2">Fecha</th>
                        <th class="border border-gray-300 px-4 py-2">Entrada</th>
                        <th class="border border-gray-300 px-4 py-2">Salida</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Mostrar las asistencias filtradas -->
                    @foreach($attendances as $attendance)
                        <tr class="text-center">
                            <td class="border border-gray-300 px-4 py-2">{{ $attendance->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $attendance->intern->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $attendance->date }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $attendance->check_in }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $attendance->check_out ?? 'No registrada' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación -->
            <!-- Se agregó la paginación de los resultados -->
            <div class="mt-4">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
