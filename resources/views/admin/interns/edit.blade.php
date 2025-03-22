<x-layouts.app :title="__('Practicantes')">

@section('content')
    <div class="container">
        <h1>Editar Practicante</h1>
        <form action="{{ route('interns.update', $intern->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label>Nombre:</label>
            <input type="text" name="name" value="{{ old('name', $intern->name) }}" required>

            <label>Apellido:</label>
            <input type="text" name="lastname" value="{{ old('lastname', $intern->lastname) }}" required>

            <button type="submit">Actualizar</button>
        </form>
    </div>
</x-layouts.app>
