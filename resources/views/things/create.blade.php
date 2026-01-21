@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Добавить вещь</h1>
    <form method="POST" action="{{ route('things.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="wrnt" class="form-label">Гарантия до (дата)</label>
            <input type="date" class="form-control" id="wrnt" name="wrnt">
        </div>
        <button type="submit" class="btn btn-success">Создать</button>
        <a href="{{ route('things.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection