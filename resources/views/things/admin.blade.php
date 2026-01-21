@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Админка: все вещи</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Хозяин</th>
                <th>Гарантия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($things as $thing)
                <tr>
                    <td>{{ $thing->name }}</td>
                    <td>{{ $thing->owner->name ?? '—' }}</td>
                    <td>{{ $thing->wrnt ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection