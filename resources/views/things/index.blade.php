<!-- страница всех вещей всех пользователей -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Все вещи</h1>
        <a href="{{ route('things.create') }}" class="btn btn-dark">Добавить вещь</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($things->isEmpty())
        <div class="text-center py-5">
            <p class="text-muted">Нет ни одной вещи.</p>
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
                 <!-- кастомные блейд директива (в AppServiceProvider.php ) -->
                     <!-- сделала пхп логику для переключения классов -->
                      <!-- выбираю первую запись из таблицы uses и сравниваю repair? work? -->
                <tbody>
                 @foreach($things as $thing)
                        <tr class="
                            @highlightOwner($thing)
                        ">
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
                                    
                                    @if(auth()->user()->isAdmin() || $thing->master === auth()->id())
                                        <a href="{{ route('things.edit', $thing) }}" class="btn btn-sm btn-outline-dark">Редактировать</a>
                                        
                                        <form action="{{ route('things.destroy', $thing) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Удалить вещь?')">
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