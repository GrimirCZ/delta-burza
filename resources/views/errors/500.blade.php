@extends('errors.layout')

@section('title', 'Chyba serveru')
@section('code', '500')
@section('message', 'Chyba serveru')

@section('steps')
    <p class="mt-4">
        Zkuste stisknout Ctrl+F5 a postup zopakovat.
    </p>
    <p class="mt-4">
        Pokud nahráváte soubory, jejichž názvy obsahují háčky a čárky, odstraňte prosím tyto písmena z názvu a
        akci zopakujte.
    </p>
    <p class="mt-4">
        Pokud ani to nepomůže, napište, prosím na <a class="link" href="mailto:faltvi@delta-studenti.cz">faltvi@delta-studenti.cz</a>.
    </p>
@endsection
