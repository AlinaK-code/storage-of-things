<!-- страница конкретной вещи (если нажать подробнее) -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $thing->name }}</h1>
    <p><strong>Описание:</strong> {{ $thing->description ?? '—' }}</p>
    <p><strong>Гарантия до:</strong> {{ $thing->wrnt ?? '—' }}</p>
    <p><strong>Хозяин:</strong> {{ $thing->owner->name }}</p>
    <p><strong>Ед. измерения</strong> {{ $thing->unit?->name ?? '—' }}</p>

    <a href="{{ route('things.edit', $thing) }}" class="btn btn-warning">Редактировать</a>
    <a href="{{ route('things.index') }}" class="btn btn-secondary">Назад к списку</a>
</div>
@endsection