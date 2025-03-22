<x-layouts.app :title="__('Practicantes')">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Lista de Practicantes</h1>

        <button onclick="openModal()" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
            + Agregar Practicante
        </button>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Nombre</th>
                        <th class="px-4 py-2 border">Apellido</th>
                        <th class="px-4 py-2 border">DNI</th>
                        <th class="px-4 py-2 border">Teléfono</th>
                        <th class="px-4 py-2 border">Institución</th>
                        <th class="px-4 py-2 border">Fecha de Inicio</th>
                        <th class="px-4 py-2 border">Fecha de Fin</th>
                        <th class="px-4 py-2 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($interns as $intern)
                        <tr>
                            <td class="px-4 py-2 border">{{ $intern->id }}</td>
                            <td class="px-4 py-2 border">{{ $intern->name }}</td>
                            <td class="px-4 py-2 border">{{ $intern->last_name }}</td>
                            <td class="px-4 py-2 border">{{ $intern->dni }}</td>
                            <td class="px-4 py-2 border">{{ $intern->phone ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border">{{ $intern->institution }}</td>
                            <td class="px-4 py-2 border">{{ $intern->start_date }}</td>
                            <td class="px-4 py-2 border">{{ $intern->end_date }}</td>
                            <td class="px-4 py-2 border text-center">
                                <a href="{{ route('interns.edit', $intern) }}" 
                                   class="bg-yellow-500 text-white px-3 py-1 rounded">Editar</a>
                                <form action="{{ route('interns.destroy', $intern) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded"
                                            onclick="return confirm('¿Estás seguro de eliminar este practicante?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">Agregar Practicante</h2>
                <form action="{{ route('interns.store') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="name" class="block text-sm font-semibold">Nombre:</label>
                        <input type="text" name="name" id="name" class="w-full border px-3 py-2" autocomplete="given-name" required>
                    </div>
                    <div class="mb-2">
                        <label for="last_name" class="block text-sm font-semibold">Apellido:</label>
                        <input type="text" name="last_name" id="last_name" class="w-full border px-3 py-2" autocomplete="family-name" required>
                    </div>
                    <div class="mb-2">
                        <label for="dni" class="block text-sm font-semibold">DNI:</label>
                        <input type="text" name="dni" id="dni" class="w-full border px-3 py-2" pattern="\d{8}" title="Debe contener 8 dígitos" autocomplete="off" required>
                    </div>
                    <div class="mb-2">
                        <label for="phone" class="block text-sm font-semibold">Teléfono:</label>
                        <input type="text" name="phone" id="phone" class="w-full border px-3 py-2" pattern="\d{9}" title="Debe contener 9 dígitos" autocomplete="tel">
                    </div>
                    <div class="mb-2">
                        <label for="institution" class="block text-sm font-semibold">Institución:</label>
                        <input type="text" name="institution" id="institution" class="w-full border px-3 py-2" autocomplete="organization" required>
                    </div>
                    <div class="mb-2">
                        <label for="start_date" class="block text-sm font-semibold">Fecha de Inicio:</label>
                        <input type="date" name="start_date" id="start_date" class="w-full border px-3 py-2" required>
                    </div>
                    <div class="mb-2">
                        <label for="end_date" class="block text-sm font-semibold">Fecha de Fin:</label>
                        <input type="date" name="end_date" id="end_date" class="w-full border px-3 py-2" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="closeModal()" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</x-layouts.app>
