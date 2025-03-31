<x-layouts.app :title="__('Practicantes')">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Lista de Practicantes</h1>

        <button onclick="openModal()" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
            + Agregar Practicante
        </button>
        {{-- boton de reporte global  --}}
        <div class="flex justify-end">
            <flux:button variant="primary" onclick="window.location='{{ route('export.global') }}'">
                Exportar Reporte Global
            </flux:button>
        </div>
        
        <!--  busqueda de practicantes mediante DNI -->
        
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-2">
                <label for="dniSearch" class="font-semibold text-gray-700">Buscar por DNI:</label>
                    <input 
                        type="text" 
                        id="dniSearch" 
                        class="border border-gray-300 p-2 rounded-md" 
                        placeholder="Buscar por DNI"
                    >
                </div>
            <button onclick="searchByDni()" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
        Buscar
    </button>
</div>

<!--  script de la busqueda para que se reacargue en la mism vista generar  -->
@if(session('email') && session('password'))
    <div class="alert alert-success">
        <strong>✅ Cuenta creada exitosamente</strong><br>
        <p><b>Correo:</b> {{ session('email') }}</p>
        <p><b>Contraseña:</b> {{ session('password') }}</p>
    </div>
@endif

<script>
    function searchByDni() {
        // Obtener el valor del campo de búsqueda
        const dni = document.getElementById('dniSearch').value;

        // Realizar la solicitud AJAX
        fetch("{{ route('interns.index') }}?dni=" + dni, {
            method: "GET",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        })
        .then(response => response.json()) // Esperar la respuesta en formato JSON
        .then(data => {
            // Actualizar el contenido de la tabla con los resultados de la búsqueda
            updateTable(data.interns);
        })
        .catch(error => console.error('Error en la búsqueda:', error));
    }

    // Función para actualizar la tabla con los nuevos datos
    function updateTable(interns) {
        const tableBody = document.querySelector('table tbody');
        tableBody.innerHTML = ''; // Limpiar la tabla actual

        // Recorrer los resultados y agregarlos a la tabla
        interns.forEach(intern => {
            const row = document.createElement('tr');
            
            row.innerHTML = `
                
                <td class="px-4 py-2 border">${intern.name}</td>
                <td class="px-4 py-2 border">${intern.lastname}</td>
                <td class="px-4 py-2 border">${intern.dni}</td>
                

                <td class="px-4 py-2 border text-center">
    
                    <button onclick="openDetailModal(${intern.name})" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">Ver más</button>

                </td>
            `;
            tableBody.appendChild(row); // Agregar la fila a la tabla
        });
    }
</script>


        <!--  vista de todos los practicantes -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 border">Nombre</th>
                        <th class="px-4 py-2 border">Apellido</th>
                        <th class="px-4 py-2 border">DNI</th>
                        <th class="px-4 py-2 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($interns as $intern)
                        <tr>
                            <td class="px-4 py-2 border">{{ $intern->name }}</td>
                            <td class="px-4 py-2 border">{{ $intern->lastname }}</td>
                            <td class="px-4 py-2 border">{{ $intern->dni }}</td>
                            <td class="px-4 py-2 border text-center">
                                <!-- Botón "Descargar Reporte Individual" -->
                                <flux:button variant="filled" onclick="window.location='{{ route('export.individual', $intern->id) }}'">
                                    Descargar Reporte Individual
                                </flux:button>
                                {{-- <flux:button icon="arrow-down-tray"variant="filled" onclick="window.location='{{ route('export.individual', $intern->id) }}'">
                                    Descargar Reporte Individual
                                </flux:button> --}}
        
                                <!-- Botón "Ver más" -->
                                <button onclick="openDetailModal({{ $intern->id }})" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                    Ver más
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        

<!-- Modal para los detalles completos del Practicante -->
<div id="detailModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white p-8 rounded-lg shadow-lg w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
        <!-- Título del Modal -->
        <h2 class="text-3xl font-semibold mb-6 text-gray-800 text-center">
            Detalles del Practicante
        </h2>

        <!-- Contenido del modal (se actualizará dinámicamente) -->
        <div id="detailContent" class="space-y-6 mb-6 text-lg text-gray-700">
           
        </div>

        <!-- Sección de Botones de acción: Editar y Eliminar -->
        <div class="flex justify-end gap-6">
            <a href="" id="editLink" class="bg-yellow-500 text-white px-6 py-3 rounded-lg text-lg hover:bg-yellow-600 transition duration-200 ease-in-out transform hover:scale-105">
                Editar
            </a>
            <form id="deleteForm" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" id="deleteButton" class="bg-red-500 text-white px-6 py-3 rounded-lg text-lg hover:bg-red-600 transition duration-200 ease-in-out transform hover:scale-105">
                    Eliminar
                </button>
            </form>
        </div>

        <!-- Botón para cerrar el modal -->
        <div class="mt-6 text-center">
            <button onclick="closeDetailModal()" class="bg-gray-500 text-white px-6 py-3 rounded-lg text-lg hover:bg-gray-600 transition duration-200 ease-in-out transform hover:scale-105 w-full sm:w-auto">
                Cerrar
            </button>
        </div>
    </div>
</div>


<script>
    // Función para abrir el modal con los detalles del practicante

    function test(e){

        console.log('test:',e)
    }
    function openDetailModal(internId) {
        // Llamar a un endpoint para obtener los detalles del practicante (AJAX)
        fetch(`/interns/${internId}`)
            .then(response => response.json())
            .then(data => {
                // Mostrar los detalles en el modal
                let content = `
                    <p><strong>Nombre:</strong> ${data.name} ${data.lastname}</p>
                    <p><strong>DNI:</strong> ${data.dni}</p>
                    <p><strong>Teléfono:</strong> ${data.phone || 'N/A'}</p>
                    <p><strong>Institución:</strong> ${data.institution}</p>
                    <p><strong>Horario:</strong> ${data.arrival_time} - ${data.departure_time}</p>
                    <p><strong>Fecha de Inicio:</strong> ${data.start_date}</p>
                    <p><strong>Fecha de Fin:</strong> ${data.end_date}</p>
                `;
                document.getElementById('detailContent').innerHTML = content;

                // Configurar los enlaces de editar y eliminar
                document.getElementById('editLink').href = `/interns/${data.id}/edit`; // Configura el enlace de editar
                document.getElementById('deleteForm').action = `/interns/${data.id}`; // Configura la acción del formulario de eliminar
                document.getElementById('deleteButton').onclick = function() {
                    return confirm('¿Estás seguro de eliminar este practicante?');
                };

                // Mostrar el modal
                document.getElementById('detailModal').classList.remove('hidden');
            });
    }

    // Función para cerrar el modal
    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>

        
        <script>
            // Función para abrir el modal con los detalles del practicante
            function openDetailModal(internId) {
                // Llamar a un endpoint para obtener los detalles del practicante (AJAX)
                fetch(`/interns/${internId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Mostrar los detalles en el modal
                        let content = `
                            <p><strong>Nombre:</strong> ${data.name} ${data.lastname}</p>
                            <p><strong>DNI:</strong> ${data.dni}</p>
                            <p><strong>Teléfono:</strong> ${data.phone || 'N/A'}</p>
                            <p><strong>Institución:</strong> ${data.institution}</p>
                            <p><strong>Horario:</strong> ${data.arrival_time} - ${data.departure_time}</p>
                            <p><strong>Fecha de Inicio:</strong> ${data.start_date}</p>
                            <p><strong>Fecha de Fin:</strong> ${data.end_date}</p>
                        `;
                        document.getElementById('detailContent').innerHTML = content;
        
                        // Configurar los enlaces de editar y eliminar
                        document.getElementById('editLink').href = `/interns/${data.id}/edit`; // Configura el enlace de editar
                        document.getElementById('deleteForm').action = `/interns/${data.id}`; // Configura la acción del formulario de eliminar
                        document.getElementById('deleteButton').onclick = function() {
                            return confirm('¿Estás seguro de eliminar este practicante?');
                        };
        
                        // Mostrar el modal
                        document.getElementById('detailModal').classList.remove('hidden');
                    });
            }
        
            // Función para cerrar el modal
            function closeDetailModal() {
                document.getElementById('detailModal').classList.add('hidden');
            }
        </script>
        
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