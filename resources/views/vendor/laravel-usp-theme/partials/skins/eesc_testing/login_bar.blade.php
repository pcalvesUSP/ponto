@section('skin_styles')
@parent {{-- devemos incluir o conteúdo existente --}}
<style>
    /* #skin_login_bar é o div pai */
    #skin_login_bar {
        display: block;
        background-color: #ffa366;
        font-size: 16px;
        color: #001980;
        padding-top: 5px;
        margin-bottom: 5px;
    }

    /* .login_logout_link formata os links correspondentes que estão nos includes */
    #skin_login_bar .login_logout_link {
        color: #001980 !important;
        text-decoration: none !important;
        font-weight: bold;
        padding-left: 5px;
        padding-right: 10px;
    }

</style>
@endsection

@section('skin_login_bar')
{{-- esta faixa está fora de container para tocar as bordas da janela --}}
<div class="d-flex">
    <div class="d-none d-sm-inline-block font-weight-bold h5 ml-3 my-0 py-0">
        {{-- config('app.name') --}}
    </div>
    <div class="d-inline-block ml-auto">
        @auth
        {{ Auth::user()->name }} |
        @include('laravel-usp-theme::partials.login_bar.logout_link')
        @else
        Não autenticado |
        @include('laravel-usp-theme::partials.login_bar.login_link')
        @endauth

    </div>
</div>
@endsection
