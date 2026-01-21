@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Мои вещи</h1>
    <a href="{{ route('things.create') }}" class="btn btn-primary mb-3">Добавить вещь</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($things->isEmpty())
        <p>У вас нет вещей.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Гарантия до</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($things as $thing)
                    <tr>
                        <td>{{ $thing->name }}</td>
                        <td>{{ $thing->description ?? '-' }}</td>
                        <td>{{ $thing->wrnt ?? '-' }}</td>
                        <td>
                            <a href="{{ route('things.show', $thing) }}" class="btn btn-sm btn-info">Просмотр</a>
                            <a href="{{ route('things.edit', $thing) }}" class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('things.destroy', $thing) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection