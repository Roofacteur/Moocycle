@extends('layouts.app')
@section('head')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection
@section('content')
<div class="container">
    <h1>Profil</h1>
    <div class="user-info">
        <p><strong>Nom :</strong> {{ auth()->user()->name }}</p>
        <p><strong>Email :</strong> {{ auth()->user()->email }}</p>
        <p><strong>Créé le :</strong> {{ auth()->user()->created_at}}</p>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Se déconnecter</button>
    </form>
</div>
@endsection
