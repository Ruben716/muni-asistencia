<div>
    <h2 class="text-xl font-bold mb-4">Registro de Asistencias</h2>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <input type="text" wire:model.defer="dni" placeholder="Ingrese su DNI"
           class="border border-gray-300 px-4 py-2 rounded w-full" 
           wire:keydown.enter="registerAttendance">


</div>
