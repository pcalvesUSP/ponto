@extends('main')

@section('content')

<div class="card">
  <div class="card-header font-weight-bold">
    {{ $pessoa['codpes'] }} {{ $pessoa['nompes'] }}
  </div>
  <div class="card-body">
    <div class="row">
      
      <div class="col-lg-auto p-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Foto</h5>
            <img style="width: 100px; float: left;" src="data:image/png;base64, {{ \Uspdev\Wsfoto::obter($pessoa['codpes']) }}" alt="foto">
          </div>
          
          <div class="card-body">
            <h5 class="card-title">Contato</h5>
            @foreach ($emails as $email)
              <i class="fas fa-envelope"></i> {{ $email }}<br />
            @endforeach
            @foreach ($telefones as $telefone)
              <i class="fas fa-phone"></i> {{ $telefone }}<br />
            @endforeach
          </div>
        </div>

        <br>

        @php
          $inBack = \Carbon\Carbon::createFromFormat('d/m/Y', request()->in)->subMonth()->format('d/m/Y');
          $outBack = \Carbon\Carbon::createFromFormat('d/m/Y', request()->out)->subMonth()->format('d/m/Y');
          $inNext = \Carbon\Carbon::createFromFormat('d/m/Y', request()->in)->addMonth()->format('d/m/Y');
          $outNext = \Carbon\Carbon::createFromFormat('d/m/Y', request()->out)->addMonth()->format('d/m/Y'); 
          $route = last(explode('/', URL::current()));
          $url = ($route == 'my') ? '/pessoas/my' : '/pessoas/' . $pessoa['codpes'] ;
        @endphp
        
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Filtrar período:</h5>
            <form method="GET">
              Início: <input name="in" value="{{ request()->in }}"><br>
              <br>
              Fim: <input name="out" value="{{ request()->out }}"><br><br>
              <button type="submit" class="btn btn-success"><i class="fa fa-solid fa-filter"></i> Filtrar</button> 
              <a href="{{ $url }}?in={{ $inBack }}&out={{ $outBack }}" 
                class="btn btn-secondary"><i class="fa fa-solid fa-arrow-left"></i> Anterior</a> 
              <a href="{{ $url }}?in={{ $inNext }}&out={{ $outNext }}" 
                class="btn btn-secondary"><i class="fa fa-solid fa-arrow-right"></i> Próximo</a>
            </form>
          </div>
        </div>
        
        <br />

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Totalizador</h5>
            
            @php
              $carga_horaria_semanal = (!App\Models\Grupo::getGroup($pessoa['codpes'])) ? 0 : App\Models\Grupo::getGroup($pessoa['codpes'])->carga_horaria;
              $carga_horaria_diaria = $carga_horaria_semanal / 5;
              $quantidade_dias_uteis = $util->contarDiasUteis(request()->in, request()->out); 
              $carga_horaria_total = $quantidade_dias_uteis * $carga_horaria_diaria;
              $arrayTotal = (!empty($total)) ? array_map('trim', explode('e', $total)) : [];
              $total_horas = (!empty($arrayTotal)) ? trim(substr($arrayTotal[0], 0, 2)) : 0;
              $total_minutos = (!empty($arrayTotal[1])) ? trim(substr($arrayTotal[1], 0, 2)) : 0;
              $total_registrado = (!empty($total)) ? $total : '0 horas';
              $carga_horaria_total_minutos = $carga_horaria_total * 60;
              $total_registrado_minutos = ($total_horas * 60) + $total_minutos;
              $saldo_minutos = $total_registrado_minutos - $carga_horaria_total_minutos;
              $saldo = $util->formatMinutes(abs($saldo_minutos));
            @endphp  

            <strong>Carga horária semanal:</strong> {{ $carga_horaria_semanal }} horas<br />
            <strong>Quantidade de dias úteis:</strong> {{ $quantidade_dias_uteis }} <br />
            <strong>Carga horária total: </strong>{{ $carga_horaria_total }} horas<br>
            <strong>Total registrado: </strong>{{ $total_registrado }} <br />
            <strong>Saldo:</strong> <span @if ($total_horas < $carga_horaria_total) style="color: #f00;" @endif>{{ $saldo }}</span>

            <br /><br />

            @can('boss')
            <a class="btn btn-info" href="/folha/{{ $pessoa['codpes'] }}/?in={{ request()->in }}&out={{ request()->out }}">
              Gerar folha de frequência <i class="fas fa-solid fa-file-pdf"></i><br />
            </a>
            @endcan

          </div>
        </div>

      </div>

      <div class="col-lg-3 p-3">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Frequência</h5>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Dia</th>
                  <th scope="col">Ocorrência</th>
                </tr>
              </thead>
              <tbody>
                @foreach($computes as $day=>$values)
                  <tr>
                    <th scope="row">{{ $day }}</th>
                    <td @if (!empty($datas[substr($day, 0, 2)]['texto'])) style="background-color: #ccc;" @endif>
                      @forelse($values as $entries)
                        @foreach($entries as $time=>$minutes)
                          {{ $time }}:
                          <b>
                            @if($minutes > 0)
                              {{ \Carbon\CarbonInterval::minutes($minutes)->cascade()->locale('pt_Br')->forHumans() }}
                            @else
                              Inválido
                            @endif
                          </b>
                          <br>
                        @endforeach
                      @empty
                        @if (!empty($datas[substr($day, 0, 2)]['texto'])) {{ $datas[substr($day, 0, 2)]['texto'] }} @else sem registro ou registro inválido @endif
                      @endforelse
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>
      <div class="col-lg-7 p-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Registros</h5>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Registro</th>
                </tr>
              </thead>
              <tbody> 
                @include('pessoas.partials.form')
              </tbody>
            </table>        
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
