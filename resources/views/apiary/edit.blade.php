@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Adicionar apiário</div>

                <div class="panel-body">
                	<form action="{{ route('post-edit.apiary', ['id' => $apiary->id]) }}" method="POST">
                		<label for="name">Nome</label>
						<input type="text" name="name" value="{{ $apiary->name }}">
                		<label for="location">Localização</label>
						<input type="text" name="location" value="{{ $apiary->location }}">
                		<label for="dominant_flora">Flora dominante</label>
						<input type="text" name="dominant_flora" value="{{ $apiary->dominant_flora }}">
					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
					    <button type="submit" class="btn btn-primary">Gravar</button>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection