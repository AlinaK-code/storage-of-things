<!-- общая страница для WORK, USED THINGS, REPAIR THINGS -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $title ?? 'Вещи' }}</h1>

    @if($things->isEmpty())
        <p>Нет вещей.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Гарантия до</th>
                    <th>Ед. измерения</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($things as $thing)
                    <tr>
                        <td>{{ $thing->name }}</td>
                        <td>{{ $thing->description ?? '-' }}</td>
                        <td>{{ $thing->wrnt ? \Carbon\Carbon::parse($thing->wrnt)->format('d.m.Y') : '-' }}</td>
                        <td>{{ $thing->unit?->symbol ?? '—' }}</td>
                        <td>
                            <a href="{{ route('things.show', $thing) }}" class="btn btn-sm btn-info">Просмотр</a>

                            {{-- Кнопки только на странице "мои вещи" --}}
                            @if(request()->routeIs('things.my'))
                                <a href="{{ route('things.edit', $thing) }}" class="btn btn-sm btn-warning">Редактировать</a>
                                <form action="{{ route('things.destroy', $thing) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Удалить</button>
                                </form>
                                <a href="{{ route('things.assign.form', $thing) }}" class="btn btn-sm btn-secondary">Передать</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection