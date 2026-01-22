<!-- общая страница для WORK, USED THINGS, REPAIR THINGS -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">{{ $title ?? 'Вещи' }}</h1>

    @if($things->isEmpty())
        <div class="text-center py-5">
            <p class="text-muted">Нет вещей.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Название</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Гарантия до</th>
                        <th scope="col">Ед. изм.</th>
                        <th scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($things as $thing)
                        <tr>
                            <td><strong>{{ $thing->name }}</strong></td>
                            <td>
                                <div style="max-width: 250px; word-wrap: break-word;">
                                    {{ $thing->currentDescription?->content ?? '—' }}
                                </div>
                            </td>
                            <td>{{ $thing->wrnt ? \Carbon\Carbon::parse($thing->wrnt)->format('d.m.Y') : '—' }}</td>
                            <td>{{ $thing->unit?->symbol ?? '—' }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('things.show', $thing) }}" class="btn btn-sm btn-outline-info">Просмотр</a>

                                    {{-- Кнопки только на странице "мои вещи" --}}
                                    @if(request()->routeIs('things.my'))
                                        <a href="{{ route('things.edit', $thing) }}" class="btn btn-sm btn-outline-dark">Редактировать</a>
                                        <form action="{{ route('things.destroy', $thing) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Удалить?')">
                                                Удалить
                                            </button>
                                        </form>
                                        <a href="{{ route('things.assign.form', $thing) }}" class="btn btn-sm btn-outline-secondary">Передать</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection