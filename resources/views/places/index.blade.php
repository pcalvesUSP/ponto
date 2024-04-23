@extends('main')

@section('content')

<div class="card">
  <div class="card-header font-weight-bold">
    Locais
  </div>
  <div class="card-body">
    <a class="btn btn-success" href="/places/create"><i class="fa fa-plus"></i> Cadastrar novo local</a>
    <br><br>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Nome</th>
        </tr>
      </thead>
      <tbody>
        @foreach($places as $place)
        <tr>
            <td>{{ $place->name }} &nbsp; <a href="/place/{{$place->id}}/edit"><i class="fas fa-pencil-alt" color="#007bff"></i></a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection