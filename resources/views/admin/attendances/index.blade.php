<x-layouts.app :title="__('Practicantes')">
    <div>
        <div class="p-6">
            <h2 class="text-xl font-bold mb-4">Registrar Asistencia</h2>
            
            <div class="mb-4">
                <input 
                    type="text" 
                    wire:model.live="dni" 
                    placeholder="Ingrese DNI" 
                    maxlength="8"
                    class="w-full p-2 border rounded-md"
                    pattern="\d{8}"
                    inputmode="numeric"
                >
            </div>
    
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
            </div>
        </div>
    </div>
</x-layouts.app>
