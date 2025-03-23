<x-layouts.app :title="__('Practicantes')">
    
   
    <div class="p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Registro de Asistencias</h1>
    
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
    
        @if($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    
        <form action="{{ route('attendances.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="flex gap-4">
                <input type="text" name="dni" placeholder="Ingrese su DNI" 
                       class="border border-gray-300 px-4 py-2 rounded w-full" required>
                
                <select name="type" class="border border-gray-300 px-4 py-2 rounded">
                    <option value="check_in">Entrada</option>
                    <option value="check_out">Salida</option>
                </select>
    
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Registrar
                </button>
            </div>
        </form>
    
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
   
    
    
    
    
</x-layouts.app>
