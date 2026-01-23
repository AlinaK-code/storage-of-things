@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Архив удалённых вещей</h1>

    @if($archives->isEmpty())
        <p class="text-muted">Архив пуст.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Хозяин</th>
                        <th>Последний пользователь</th>
                        <th>Место</th>
                        <th>Восстановлена?</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($archives as $item)
                        <tr class="{{ $item->restored ? 'table-success' : '' }}">
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description ?? '—' }}</td>
                            <td>{{ $item->owner_name }}</td>
                            <td>{{ $item->last_user_name ?? '—' }}</td>
                            <td>{{ $item->place_name ?? '—' }}</td>
                            <td>
                                @if($item->restored)
                                    <span class="badge bg-success">Да</span>
                                    <small class="d-block">{{ $item->restored_by_name }}<br>{{ $item->restored_at?->format('d.m.Y') }}</small>
                                @else
                                    <span class="badge bg-secondary">Нет</span>
                                @endif
                            </td>
                            <td>
                                @if(!$item->restored && (auth()->user()->isAdmin() || auth()->id() === $item->owner_id))
                                    <form action="{{ route('archive.restore', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary" onclick="return confirm('Восстановить вещь?')">
                                            Восстановить
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-3">← Назад</a>
</div>
@endsection