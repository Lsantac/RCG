
@extends('master')

@section('content')

    <div class="container">
      
        <div class="row">
            
            <div class="col">
                <div class="card" style="width: 100%;">
                    <h5 class="card-header header-oferta"><a href="" class="texto-oferta"> Minhas Ofertas</a></h5>
                    <div class="card-body">

                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-chat-left-dots-fill texto-pendente"></h4>
                        </div>
                        <div class="col-11">
                          <p class="card-text">
                            Existem <span style="color:rgb(18, 158, 14);"><b>{{$num_mens_unica}}</b></span> mensagens de Necessidades ou Trocas de outros participantes esperando resposta. 
                         </p>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-chat-left-dots-fill texto-em-andamento"></h4>
                        </div>
                        <div class="col-11">
                          <p class="card-text">
                            Existem <span style="color:rgb(197, 15, 233);"><b>{{$num_mens_anda}}</b></span> transações em andamento para suas Ofertas. 
                          </p>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-check-circle-fill texto-parc-finalizada"></h4>
                        </div>
                        <div class="col-11">
                          <p>
                            Existem <span style="color:rgb(15, 135, 233);"><b>{{$num_ofp_parc}}</b></span> confirmações de Necessidades ou Trocas de outros participantes esperando sua confirmação. 
                          </p>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-check-circle-fill texto-finalizada"></h4>
                        </div>
                        <div class="col-11">
                              @if($num_ofp_final > 1)
                                <p>
                                Existem <span style="color:rgb(15, 29, 233);"><b>{{$num_ofp_final}}</b></span> Ofertas suas já finalizadas. 
                                </p>
                              @else
                                <p>
                                Existe <span style="color:rgb(15, 29, 233);"><b>{{$num_ofp_final}}</b></span> Oferta sua já finalizada. 
                                </p>
                              @endif
                        </div>
                      </div>
                      
                    </div>
                  </div>
            </div>
            <div class="col">
                <div class="card" style="width: 100%;">
                    <h5 class="card-header header-necessidade"><a href="" class="texto-necessidade"> Minhas Necessidades</a></h5>
                    <div class="card-body">
                      
                      <p class="card-text">
                        Existem <span style="color:blue;"><b>X</b></span> mensagens de Ofertas de outros participantes esperando resposta. 
                      </p>
                      <p class="card-text">
                        Existem <span style="color:rgb(36, 5, 148) ;"><b>Z</b></span> transações em andamento para suas Necessidades. 
                      </p>
                      <p>
                        Existem <span style="color:purple ;"><b>Y</b></span> confirmações de ofertas de outros participantes esperando sua confirmação. 
                      </p>
                      <br>
           
           
                    </div>
                  </div>
            </div>
          </div>
      
    </div>
    


@endsection