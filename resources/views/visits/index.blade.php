@extends('layouts.layout')

@section('title', 'Visits Statistics')

@section('content')
    <h2>Visits</h2>
    <a href="{{ route('visits.stats') }}" class="btn btn-outline-dark">View Stats</a>
    <table class="table table-hover table-sm">
        <thead>
        <tr>
            <th>ID</th>
            <th>IP</th>
            <th>City</th>
            <th>Device</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($visits as $visit)
            <tr>
                <td>{{ $visit->id }}</td>
                <td>{{ $visit->ip }}</td>
                <td>{{ $visit->city }}</td>
                <td>{{ $visit->device }}</td>
                <td>{{ $visit->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
