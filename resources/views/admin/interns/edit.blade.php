<x-layouts.app :title="__('Editar Practicante')">
    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow mt-6">
        <h1 class="text-2xl font-bold mb-4 text-center text-gray-900 dark:text-white">Editar Practicante</h1>

        <form action="{{ route('interns.update', $intern->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold">Nombre:</label>
                <input type="text" name="name" value="{{ old('name', $intern->name) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
            </div>

            <!-- Apellido -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold">Apellido:</label>
                <input type="text" name="lastname" value="{{ old('lastname', $intern->lastname) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
            </div>

            <!-- DNI -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold">DNI:</label>
                <input type="text" name="dni" value="{{ old('dni', $intern->dni) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
            </div>

            <!-- Teléfono -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold">Teléfono:</label>
                <input type="text" name="phone" value="{{ old('phone', $intern->phone) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>

            <!-- Hora de Entrada -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold">Hora de Entrada:</label>
                <input type="time" name="arrival_time" value="{{ old('arrival_time', $intern->arrival_time) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
            </div>

            <!-- Hora de Salida -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold">Hora de Salida:</label>
                <input type="time" name="departure_time" value="{{ old('departure_time', $intern->departure_time) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
            </div>

            <!-- Fecha de Inicio -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold">Fecha de Inicio:</label>
                <input type="date" name="start_date" value="{{ old('start_date', $intern->start_date) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
            </div>

            <!-- Fecha de Fin -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold">Fecha de Fin:</label>
                <input type="date" name="end_date" value="{{ old('end_date', $intern->end_date) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
            </div>

            <!-- Institución -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold">Institución:</label>
                <input type="text" name="institution" value="{{ old('institution', $intern->institution) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>

            <!-- Turno y Especialidad -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="turno" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Turno:</label>
                    <select name="turno" id="turno" class="w-full border px-3 py-2 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Seleccionar...</option>
                        <option value="M" {{ old('turno', $intern->turno) == 'M' ? 'selected' : '' }}>Mañana</option>
                        <option value="T" {{ old('turno', $intern->turno) == 'T' ? 'selected' : '' }}>Tarde</option>
                    </select>
                </div>
                <div>
                    <label for="espacialidad" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Especialidad:</label>
                    <select name="espacialidad" id="espacialidad" class="w-full border px-3 py-2 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Seleccionar...</option>
                        <option value="P" {{ old('espacialidad', $intern->espacialidad) == 'P' ? 'selected' : '' }}>Programación</option>
                        <option value="S" {{ old('espacialidad', $intern->espacialidad) == 'S' ? 'selected' : '' }}>Soporte</option>
                        <option value="R" {{ old('espacialidad', $intern->espacialidad) == 'R' ? 'selected' : '' }}>Redes</option>
                    </select>
                </div>
            </div>

            <!-- Fecha de Cumpleaños -->
            <div>
                <label for="happy" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Fecha de Cumpleaños:</label>
                <input type="date" name="happy" id="happy" value="{{ old('happy', $intern->happy) }}"
                    class="w-full border px-3 py-2 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
            </div>

            <!-- Botones -->
            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('interns.index') }}"
                    class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition duration-200">
                    Cancelar
                </a>

                <flux:button type="submit" variant="primary">Actualizar</flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
