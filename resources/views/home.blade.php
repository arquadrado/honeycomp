@extends('layouts.app')

@section('content')
<div id="app">
    <div class="dashboard">
        <div class="sidebar">
            <div class="header">
                <div class="logo" style="background-image: url('/img/logo-mel.png')">
                </div>
                <span class="site-name">Companhia do Mel</span>
                <div class="profile">
                    <div class="dropdown">
                        <a href="#" class="profile-name" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Desconectar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="create">
                <a class="add-item" href="{{ route('create.apiary') }}">+</a>
                <span>Apiários</span>
            </div>
            <div class="list">
                <div class="apiary" v-for="apiary in apiaries" v-on:click="selectApiary(apiary)" v-bind:class="{ 'active': isCurrentApiary(apiary) }">@{{ apiary.name }}</div>
            </div>
            <div v-cloak class="apiary-info">
                <span class="title">Info</span>
                <div class="field name">
                    <label for="apiary-name">Nome</label>
                    <span id="apiary-name">@{{ selectedApiary.name }}</span>
                </div>
                <div class="field location">
                    <label for="apiary-location">Localização</label>
                    <span id="apiary-location">@{{ selectedApiary.location }}</span>
                </div>
                <div class="field flora">
                    <label for="apiary-location">Flora</label>
                    <span id="apiary-location">@{{ selectedApiary.dominant_flora }}</span>
                </div>
                <div class="field beehives-number">
                    <label for="apiary-beehives-number">Nº de colmeias</label>
                    <span id="apiary-beehives-number">@{{ selectedApiary.beehives.length }}</span>
                </div>
                <div class="options">
                    <a href="@{{ selectedApiary.editor_route }}" class="option edit">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        Editar
                    </a>
                    <a class="option delete" v-on:click="deleteApiary(selectedApiary)">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Apagar
                    </a>                    
                </div>
            </div>
        </div>            
        <div class="content">
            <apiary :apiary="selectedApiary"></apiary>
            <div class="info-panel">
                <div class="create-beehive">
                    <a class="add-item" href="@{{ selectedApiary.create_beehive_route }}">+</a>
                    <span>Adicionar colmeia</span>
                </div>
            </div>
        </div> 
    </div>    
</div>


@include('apiary.components.apiary')
@include('apiary.components.info')
@include('apiary.components.beehives')
@include('apiary.components.settings')


@endsection
