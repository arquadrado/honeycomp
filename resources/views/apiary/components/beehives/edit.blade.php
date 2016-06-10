@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $data['context'] === 'create' ? 'Adicionar colmeia' : 'Editar colmeia' }}</div>
                <div class="panel-body">
                	<form action="{{ route('post-edit.beehive', ['apiaryId' => $data['apiary_id'], 'beehiveId' => is_null($data['beehive']) ? null : $data['beehive']->id ]) }}" method="POST">
                		<label for="name">Nome</label>
						<input type="text" name="name" value="{{ !is_null($data['beehive']) ? $data['beehive']->name : '' }}">
                		<label for="type">Tipo</label>
						<input type="text" name="type" value="{{ !is_null($data['beehive']) ? $data['beehive']->type : '' }}">
					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
					    <button type="submit" class="btn btn-primary">Gravar</button>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection