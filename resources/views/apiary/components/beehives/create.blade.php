@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Adicionar apiário</div>

                <div class="panel-body">
                	<form action="{{ route('post-create.beehive', ['apiaryId' => $apiary->id]) }}" method="POST">
                		<label for="name">Nome</label>
						<input type="text" name="name" value="">
                		<label for="type">Tipo</label>
						<input type="text" name="type" value="">
						<input type="hidden" name="apiary_id" value="{{ $apiary->id }}">
					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
					    <button type="submit" class="btn btn-primary">Gravar</button>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection