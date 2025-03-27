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
                        <th class="px-4 py-2 border">Horario</th>
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
                            <td class="px-4 py-2 border">{{ $intern->lastname }}</td>
                            <td class="px-4 py-2 border">{{ $intern->dni }}</td>
                            <td class="px-4 py-2 border">{{ $intern->phone ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border">{{ $intern->institution }}</td>
                            <td class="px-4 py-2 border">{{ $intern->arrival_time }} - {{ $intern->departure_time }}</td>
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
        <div class="custom-pagination">
            {{-- Previous Button --}}
            @if ($interns->currentPage() > 1)
                <a href="{{ $interns->previousPageUrl() }}" class="pagination-button previous-page">Previous</a>
            @else
                <span class="pagination-button disabled">Previous</span>
            @endif
        
            {{-- Page Numbers --}}
            @for ($i = 1; $i <= $interns->lastPage(); $i++)
                <a href="{{ $interns->url($i) }}" class="pagination-button page-number {{ $i == $interns->currentPage() ? 'active' : '' }}">{{ $i }}</a>
            @endfor
        
            {{-- Next Button --}}
            @if ($interns->hasMorePages())
                <a href="{{ $interns->nextPageUrl() }}" class="pagination-button next-page">Next</a>
            @else
                <span class="pagination-button disabled">Next</span>
            @endif
        </div>
        
        <style>
            /* Contenedor principal de la paginación */
            .custom-pagination {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 5px;
                flex-wrap: wrap; /* Permite el ajuste en pantallas más pequeñas */
                padding: 10px 0;
                overflow: hidden; /* Para evitar que se desborde el contenido */
            }
        
            /* Botón de paginación común */
            .pagination-button {
                padding: 8px 16px;
                border-radius: 4px;
                background-color: #3498db;
                color: #fff;
                text-decoration: none;
                font-size: 14px;
                font-weight: 600;
                transition: all 0.3s ease;
                min-width: 50px; /* Garantiza que los botones no sean demasiado pequeños */
                text-align: center;
            }
        
            /* Efecto hover */
            .pagination-button:hover {
                background-color: #2980b9;
                transform: translateY(-2px);
            }
        
            /* Estado deshabilitado */
            .pagination-button.disabled {
                background-color: #bdc3c7;
                color: #7f8c8d;
                cursor: not-allowed;
                pointer-events: none;
            }
        
            /* Página activa */
            .pagination-button.active {
                background-color: #e74c3c;
                color: #fff;
            }
        
            /* Estilo del botón "Previous" y "Next" */
            .previous-page, .next-page {
                font-weight: 700;
            }
        
            /* Estilos responsivos */
            @media (max-width: 600px) {
                .pagination-button {
                    padding: 6px 12px;
                    font-size: 12px;
                    min-width: 40px; /* Botones más pequeños en pantallas pequeñas */
                }
        
                .custom-pagination {
                    padding: 8px 0; /* Reduce el espacio alrededor en pantallas pequeñas */
                }
            }
        
            @media (max-width: 400px) {
                .pagination-button {
                    padding: 4px 10px;
                    font-size: 10px;
                    min-width: 30px;
                }
        
                .custom-pagination {
                    gap: 3px; /* Reduce el espacio entre los botones en pantallas muy pequeñas */
                }
            }
        </style>
        

        <div id="modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">Agregar Practicante</h2>
                <form action="{{ route('interns.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-2">
                            <label for="name" class="block text-sm font-semibold">Nombre:</label>
                            <input type="text" name="name" id="name" class="w-full border px-3 py-2 rounded" autocomplete="given-name" required>
                        </div>
                        <div class="mb-2">
                            <label for="lastname" class="block text-sm font-semibold">Apellido:</label>
                            <input type="text" name="lastname" id="lastname" class="w-full border px-3 py-2 rounded" autocomplete="family-name" required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-2">
                            <label for="dni" class="block text-sm font-semibold">DNI:</label>
                            <input type="text" name="dni" id="dni" class="w-full border px-3 py-2 rounded" pattern="\d{8}" title="Debe contener 8 dígitos" autocomplete="off" required>
                        </div>
                        <div class="mb-2">
                            <label for="phone" class="block text-sm font-semibold">Teléfono:</label>
                            <input type="text" name="phone" id="phone" class="w-full border px-3 py-2 rounded" pattern="\d{9}" title="Debe contener 9 dígitos" autocomplete="tel">
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <label for="institution" class="block text-sm font-semibold">Institución:</label>
                        <input type="text" name="institution" id="institution" class="w-full border px-3 py-2 rounded" autocomplete="organization" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-2">
                            <label for="arrival_time" class="block text-sm font-semibold">Hora de Llegada:</label>
                            <input type="time" name="arrival_time" id="arrival_time" class="w-full border px-3 py-2 rounded" required>
                        </div>
                        <div class="mb-2">
                            <label for="departure_time" class="block text-sm font-semibold">Hora de Salida:</label>
                            <input type="time" name="departure_time" id="departure_time" class="w-full border px-3 py-2 rounded" required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-2">
                            <label for="start_date" class="block text-sm font-semibold">Fecha de Inicio:</label>
                            <input type="date" name="start_date" id="start_date" class="w-full border px-3 py-2 rounded" required>
                        </div>
                        <div class="mb-2">
                            <label for="end_date" class="block text-sm font-semibold">Fecha de Fin:</label>
                            <input type="date" name="end_date" id="end_date" class="w-full border px-3 py-2 rounded" required>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeModal()" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancelar</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Guardar</button>
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