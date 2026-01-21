@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $place->name }}</h1>

    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Описание:</strong> {{ $place->description ?? '—' }}</p>
            <p><strong>Ремонт:</strong> {{ $place->repair ? 'Да' : 'Нет' }}</p>
            <p><strong>В работе:</strong> {{ $place->work ? 'Да' : 'Нет' }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('places.edit', $place) }}" class="btn btn-warning">Редактировать</a>
        <a href="{{ route('places.index') }}" class="btn btn-secondary">Назад к списку</a>
    </div>
</div>
@endsection