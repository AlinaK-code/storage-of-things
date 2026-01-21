@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Добавить место хранения</h1>

    <form method="POST" action="{{ route('places.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Название *</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="repair" name="repair" {{ old('repair') ? 'checked' : '' }}>
            <label class="form-check-label" for="repair">Специальное место: ремонт</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="work" name="work" {{ old('work') ? 'checked' : '' }}>
            <label class="form-check-label" for="work">Находится в работе</label>
        </div>

        <button type="submit" class="btn btn-success">Создать</button>
        <a href="{{ route('places.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection