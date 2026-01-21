@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>
    @if($things->isEmpty())
        <p>Нет вещей.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Гарантия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($things as $thing)
                    <tr>
                        <td>{{ $thing->name }}</td>
                        <td>{{ $thing->description ?? '-' }}</td>
                        <td>{{ $thing->wrnt ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('things.index') }}" class="btn btn-secondary">← Все вещи</a>
</div>
@endsection