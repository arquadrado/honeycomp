@extends('layouts.app')

@section('content')
<div id="app">
    <div class="dashboard">
        <div class="sidebar">
            <div class="header">Companhia do Mel</div>
            <div class="profile">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Desconectar</a></li>
                    </ul>
                </div>
            </div>
            <div class="create">
                <span>Apiários</span>
                <a href="{{ route('create.apiary') }}">+</a>
            </div>
            <div class="list">
                <div class="apiary" v-for="apiary in apiaries" v-on:click="selectApiary(apiary)">@{{ apiary.name }}</div>
            </div>
        </div>            
        <div class="content">
            <div class="info">
                <label for="name">Nome</label>
                <div class="name">@{{ selectedApiary.name }}</div>
                <label for="name">Localização</label>
                <div class="location">@{{ selectedApiary.location }}</div>
                <label for="name">Flora dominante</label>
                <div class="dominant-flora">@{{ selectedApiary.dominant_flora }}</div>                
            </div>
            <div class="control-panel">
                <div class="action">
                    <a href="@{{ selectedApiary.editor_route }}">Editar</a>
                </div>
                <div class="action" v-on:click="deleteApiary(selectedApiary)">
                    <a href="#">Apagar</a>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection
