<x-layouts.app :title="__('Historial de Asistencias')">
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Historial de Asistencias</h2>

        <!-- Filtro para seleccionar día, semana, mes -->
        <form method="GET" action="{{ route('attendance.history') }}" class="mb-4">
            <label for="filter" class="mr-2">Filtrar por:</label>
            <select name="filter" id="filter" onchange="this.form.submit()" class="p-2 border rounded">
                <option value="day" {{ $filter == 'day' ? 'selected' : '' }}>Día</option>
                <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Semana</option>
                <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Mes</option>
            </select>
        </form>

        <!-- Mostrar las asistencias agrupadas -->
        @foreach($attendances as $date => $dailyAttendances)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-4">
                <!-- Mostrar la fecha del grupo -->
                <h3 class="text-lg font-semibold mb-4">
                    @if($filter == 'day')
                        {{ Carbon::parse($date)->format('d/m/Y') }}
                    @elseif($filter == 'week')
                        Semana: {{ $date }} <!-- Mostrar semana en formato Y-W -->
                    @elseif($filter == 'month')
                        Mes: {{ Carbon::parse($date)->format('m/Y') }} <!-- Mostrar mes en formato MM/YYYY -->
                    @endif
                </h3>

                <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Practicante</th>
                            <th class="border border-gray-300 px-4 py-2">Entrada</th>
                            <th class="border border-gray-300 px-4 py-2">Salida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyAttendances as $attendance)
                            <tr class="text-center">
                                <td class="border border-gray-300 px-4 py-2">{{ $attendance->id }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $attendance->intern->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $attendance->check_in }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $attendance->check_out ?? 'No registrada' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</x-layouts.app>
