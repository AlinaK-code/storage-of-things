@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать вещь</h1>
    <form method="POST" action="{{ route('things.update', $thing) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Название</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $thing->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $thing->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Единица измерения</label>
            <select name="unit_id" class="form-control">
                <option value="">Не указана</option>
                @foreach(App\Models\Unit::all() as $unit)
                    <option value="{{ $unit->id }}" {{ old('unit_id', $thing->unit_id ?? '') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }} ({{ $unit->symbol }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="wrnt" class="form-label">Гарантия до (дата)</label>
            <input type="date" class="form-control" id="wrnt" name="wrnt" value="{{ old('wrnt', $thing->wrnt) }}">
        </div>
        <button type="submit" class="btn btn-warning">Сохранить</button>
        <a href="{{ route('things.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection