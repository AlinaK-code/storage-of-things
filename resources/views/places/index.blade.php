@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Места хранения</h1>
    <a href="{{ route('places.create') }}" class="btn btn-primary mb-3">Добавить место</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($places->isEmpty())
        <p>Нет мест хранения.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Ремонт?</th>
                    <th>В работе?</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($places as $place)
                    <tr>
                        <td>{{ $place->name }}</td>
                        <td>{{ $place->description ?? '-' }}</td>
                        <td>{{ $place->repair ? 'Да' : 'Нет' }}</td>
                        <td>{{ $place->work ? 'Да' : 'Нет' }}</td>
                        <td>
                            <a href="{{ route('places.show', $place) }}" class="btn btn-sm btn-info">Просмотр</a>
                            <a href="{{ route('places.edit', $place) }}" class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('places.destroy', $place) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить это место?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection