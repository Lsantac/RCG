
@extends('master')

@section('content')

    <div class="container">
      
        <div class="row">
            
            <div class="col">
                <div class="card" style="width: 100%;">
                    <h5 class="card-header header-oferta"><a style="text-decoration: none;" href="/ofertas_part/{{Session::get('id_logado')}}" class="texto-oferta bi-arrow-up-circle-fill"> Minhas Ofertas</a></h5>
                    <div class="card-body">

                      <a href="" style="text-decoration: none;">
                        <div class="row">
                          <div class="col-1">
                            <h4 class="bi bi-chat-left-dots-fill texto-pendente"></h4>
                          </div>
                          <div class="col-11">
                            <p class="card-text" style="color:black;">
                              Existem <span style="color:rgb(18, 158, 14);"><b>{{$num_mens_unica_of_tr}}</b></span> mensagens de Necessidades ou Trocas de outros participantes esperando resposta. 
                          </p>
                          </div>
                        </div>
                      </a>

                      <a href="" style="text-decoration: none;">
                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-chat-left-dots-fill texto-em-andamento"></h4>
                        </div>
                        <div class="col-11">
                          <p class="card-text" style="color:black;">
                            Existem <span style="color:rgb(197, 15, 233);"><b>{{$num_mens_anda_of_tr}}</b></span> transações em andamento para suas Ofertas. 
                          </p>
                        </div>
                      </div>
                      </a>

                      <a href="" style="text-decoration: none;">
                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-check-circle-fill texto-parc-finalizada"></h4>
                        </div>
                        <div class="col-11">
                          <p style="color:black;">
                            Existem <span style="color:rgb(15, 135, 233);"><b>{{$num_ofp_parc}}</b></span> confirmações de Necessidades ou Trocas de outros participantes esperando sua finalização. 
                          </p>
                        </div>
                      </div>
                      </a>

                      <a href="" style="text-decoration: none;">
                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-check-circle-fill texto-finalizada"></h4>
                        </div>
                        <div class="col-11">
                              @if($num_ofp_final > 1)
                                <p style="color:black;">
                                Existem <span style="color:rgb(15, 29, 233);"><b>{{$num_ofp_final}}</b></span> Ofertas suas já finalizadas. 
                                </p>
                              @else
                                <p style="color:black;">
                                Existe <span style="color:rgb(15, 29, 233);"><b>{{$num_ofp_final}}</b></span> Oferta sua já finalizada. 
                                </p>
                              @endif
                        </div>
                      </div>
                      </a>
                      
                    </div>
                  </div>
            </div>
            <div class="col">
                <div class="card" style="width: 100%;">
                    <h5 class="card-header header-necessidade"><a style="text-decoration: none;" href="/necessidades_part/{{Session::get('id_logado')}}" class="texto-necessidade bi-arrow-down-circle-fill"> Minhas Necessidades</a></h5>
                    <div class="card-body">
                      
                      <a href="" style="text-decoration: none;">
                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-chat-left-dots-fill texto-pendente"></h4>
                        </div>
                        <div class="col-11">
                          <p class="card-text" style="color:black;">
                            Existem <span style="color:rgb(18, 158, 14);"><b>{{$num_mens_unica_nec}}</b></span> mensagens de Ofertas de outros participantes esperando resposta. 
                         </p>
                        </div>
                      </div>
                      </a>

                      <a href="" style="text-decoration: none;">
                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-chat-left-dots-fill texto-em-andamento"></h4>
                        </div>
                        <div class="col-11">
                          <p class="card-text" style="color:black;">
                            Existem <span style="color:rgb(197, 15, 233);"><b>{{$num_mens_anda_nec}}</b></span> transações em andamento para suas Necessidades. 
                          </p>
                        </div>
                      </div>
                      </a>

                      <a href="" style="text-decoration: none;">
                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-check-circle-fill texto-parc-finalizada"></h4>
                        </div>
                        <div class="col-11">
                          <p style="color:black;">
                            Existem <span style="color:rgb(15, 135, 233);"><b>{{$num_nec_parc}}</b></span> confirmações de Ofertas de outros participantes esperando sua finalização. 
                          </p>
                        </div>
                      </div>
                      </a>

                      <a href="" style="text-decoration: none;">
                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-check-circle-fill texto-finalizada"></h4>
                        </div>
                        <div class="col-11">
                              @if($num_nec_final > 1)
                                <p style="color:black;">
                                Existem <span style="color:rgb(15, 29, 233);"><b>{{$num_nec_final}}</b></span> Necessidades suas já finalizadas. 
                                </p>
                              @else
                                <p style="color:black;">
                                Existe <span style="color:rgb(15, 29, 233);"><b>{{$num_nec_final}}</b></span> Necessidade sua já finalizada. 
                                </p>
                              @endif
                        </div>
                      </div>
                      </a>  
           
                    </div>
                  </div>
            </div>
          </div>
      
    </div>
    


@endsection