<!-- страница конкретной вещи (если нажать подробнее) -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <h2 class="mb-0">{{ $thing->name }}</h2>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Гарантия до:</strong> 
                        {{ $thing->wrnt ? \Carbon\Carbon::parse($thing->wrnt)->format('d.m.Y') : '—' }}
                    </p>
                    <p class="mb-2"><strong>Хозяин:</strong> {{ $thing->owner->name ?? '—' }}</p>
                    <p class="mb-0"><strong>Ед. измерения:</strong> {{ $thing->unit?->symbol ?? '—' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-0"><strong>Актуальное описание:</strong></p>
                    <div class="bg-light p-3 rounded mt-1">
                        {{ $thing->currentDescription?->content ?? 'Описание отсутствует' }}
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                @if(auth()->id() === $thing->master || auth()->user()->isAdmin())
                    <a href="{{ route('things.edit', $thing) }}" class="btn btn-outline-dark">Редактировать</a>
                @endif
                <a href="{{ route('things.index') }}" class="btn btn-outline-secondary">Назад к списку</a>
            </div>
        </div>
    </div>

    <!-- История описаний -->
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-white border-bottom">
            <h3 class="h5 mb-0 text-muted">История описаний</h3>
        </div>
        <div class="card-body">
            @if($descriptions->isEmpty())
                <p class="text-muted">Нет сохранённых описаний.</p>
            @else
                @foreach($descriptions as $desc)
                    <div class="border-start border-3 ps-3 mb-3 pb-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                {{ $desc->content }}
                                @if($desc->is_current)
                                    <span class="badge bg-success ms-2">Актуальное</span>
                                @endif
                            </div>
                            <small class="text-muted">{{ $desc->created_at->format('d.m.Y H:i') }}</small>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Форма добавления нового описания -->
    @if(auth()->id() === $thing->master || auth()->user()->isAdmin())
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-white border-bottom">
                <h3 class="h5 mb-0 text-muted">Добавить новое описание</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('things.description.add', $thing) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea 
                            name="content" 
                            class="form-control" 
                            rows="3"
                            placeholder="Введите новое описание..." 
                            required
                        ></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark">Добавить описание</button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection