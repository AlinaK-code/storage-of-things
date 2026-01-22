<!-- страница назначения вещи -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Передать вещь: {{ $thing->name }}</h2>

    <form method="POST" action="{{ route('things.assign', $thing) }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Получатель</label>
            <select name="user_id" class="form-control" required>
                <option value="">Выберите пользователя</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Место хранения</label>
            <select name="place_id" class="form-control" required>
                <option value="">Выберите место</option>
                @foreach($places as $place)
                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Количество</label>
            <input type="number" name="amount" class="form-control" min="1" value="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Передать</button>
        <a href="{{ route('things.show', $thing) }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection