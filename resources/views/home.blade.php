
@extends('master')

@section('content')

    <div class="container">
      
        <div class="row">
            
            <div class="col">
                <div class="card" style="width: 100%;">
                    <h5 class="card-header header-oferta">Minhas Ofertas</h5>
                    <div class="card-body">
                      
                      <p class="card-text">
                         Existem <span style="color:blue ;"><b>X</b></span> mensagens de Necessidades e Trocas de outros participantes esperando resposta. 
                      </p>
                      <p class="card-text">
                        Existem <span style="color:rgb(36, 5, 148) ;"><b>Z</b></span> transações em andamento para suas Ofertas. 
                      </p>

                      <p>
                        Existem <span style="color:purple ;"><b>Y</b></span> confirmações de Necessidades e Trocas de outros participantes esperando sua confirmação. 
                      </p>
                      <a href="#" class="btn btn-sm btn-primary">Conferir mensagens</a>
                      <a href="#" class="btn btn-sm btn-conferir-andamentos">Conferir andamentos</a>
                      <a href="#" class="btn btn-sm btn-conferir-confirmacoes">Conferir confirmações</a>
                      <a href="#" class="btn btn-sm btn-ofertas">Minhas Ofertas</a>
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
                      <p class="card-text">
                        Existem <span style="color:rgb(36, 5, 148) ;"><b>Z</b></span> transações em andamento para suas Necessidades. 
                      </p>
                      <p>
                        Existem <span style="color:purple ;"><b>Y</b></span> confirmações de ofertas de outros participantes esperando sua confirmação. 
                      </p>
                      <br>
                      <a href="#" class="btn btn-sm btn-primary">Conferir mensagens</a>
                      <a href="#" class="btn btn-sm btn-conferir-andamentos">Conferir andamentos</a>
                      <a href="#" class="btn btn-sm btn-conferir-confirmacoes">Conferir confirmações</a>
                      <a href="#" class="btn btn-sm btn-necessidades">Minhas Necessidades</a>
                    </div>
                  </div>
            </div>
          </div>
      
    </div>
    


@endsection