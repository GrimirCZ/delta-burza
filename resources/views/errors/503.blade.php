@extends('errors.layout')

@section('title', 'Údržba serveru')
@section('code', '503')
@section('message', 'Právě probíhá údržba serveru')

@section('steps')
    <p class="mt-4">
        Právě na serveru provádíme údržbu.
    </p>
    <p>
        Rozsah úržby: 22:00 - 22:30
    </p>
@endsection
