@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Места хранения</h1>
        <a href="{{ route('places.create') }}" class="btn btn-dark">Добавить место</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($places->isEmpty())
        <div class="text-center py-5">
            <p class="text-muted">Нет ни одного места хранения.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Название</th>
                        <th scope="col">Описание</th>
                        <th scope="col" class="text-center">Ремонт?</th>
                        <th scope="col" class="text-center">В работе?</th>
                        <th scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($places as $place)
                        <tr>
                            <td><strong>{{ $place->name }}</strong></td>
                            <td>
                                <div style="max-width: 220px; word-wrap: break-word;">
                                    {{ $place->description ?? '—' }}
                                </div>
                            </td>
                            <td class="text-center">{{ $place->repair ? 'Да' : 'Нет' }}</td>
                            <td class="text-center">{{ $place->work ? 'Да' : 'Нет' }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('places.show', $place) }}" class="btn btn-sm btn-outline-info">Просмотр</a>
                                    <a href="{{ route('places.edit', $place) }}" class="btn btn-sm btn-outline-dark">Редактировать</a>
                                    <form action="{{ route('places.destroy', $place) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Удалить это место?')">
                                            Удалить
                                        </button>
                                    </form>
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