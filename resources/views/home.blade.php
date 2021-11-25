
@extends('master')

@section('content')

    <div class="container">
      
        <div class="row">
            
            <div class="col">
                <div class="card" style="width: 100%;">
                    <h5 class="card-header header-oferta">Minhas Ofertas</h5>
                    <div class="card-body">
                      
                      <p class="card-text">
                         Existem <span style="color:blue ;"><b>X</b></span> mensagens de necessidades ou trocas de outros participantes esperando resposta. 
                      </p>
                      <p>
                        Existem <span style="color:purple ;"><b>Y</b></span> confirmações de necessidades ou trocas de outros participantes esperando sua confirmação. 
                      </p>
                      <a href="#" class="btn btn-primary">Conferir mensagens</a>
                      <a href="#" class="btn btn-conferir-confirmacoes">Conferir confirmações</a>
                      <a href="#" class="btn btn-ofertas">Incluir Oferta</a>
                    </div>
                  </div>
            </div>
            <div class="col">
                <div class="card" style="width: 100%;">
                    <h5 class="card-header header-necessidade">Minhas Necessidades</h5>
                    <div class="card-body">
                      
                      <p class="card-text">
                        Existem <span style="color:blue;"><b>X</b></span> mensagens de ofertas de outros participantes esperando resposta. 
                      </p>
                      <p>
                        Existem <span style="color:purple ;"><b>Y</b></span> confirmações de ofertas de outros participantes esperando sua confirmação. 
                      </p>
                      <br>
                      <a href="#" class="btn btn-primary">Conferir mensagens</a>
                      <a href="#" class="btn btn-conferir-confirmacoes">Conferir confirmações</a>
                      <a href="#" class="btn btn-necessidades">Incluir Necessidade</a>
                    </div>
                  </div>
            </div>
          </div>
      
    </div>
    


@endsection