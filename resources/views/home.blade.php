
@extends('master')

@section('content')

    <div class="container">
      
        <div class="row">
            
            <div class="col">
                <div class="card" style="width: 100%;">
                    <h5 class="card-header header-oferta"><a style="text-decoration: none;" href="/ofertas_part/{{Session::get('id_logado')}}" class="texto-oferta bi-arrow-up-circle-fill"> Minhas Ofertas</a></h5>
                    <div class="card-body">

                      <a href="/cons_trans_ofertas_part/{{2}}/{{Session::get('id_logado')}}" style="text-decoration: none;">
                        <div class="row">
                          <div class="col-1">
                            <h4 class="bi bi-chat-left-dots-fill texto-em-andamento"></h4>
                          </div>
                          <div class="col-11">
                            <p class="card-text" style="color:black;">
                              @if(($num_mens_anda_of_tr > 1) or ($num_mens_anda_of_tr == 0))
                                  Existem <span style="color:rgb(197, 15, 233);"><b>{{$num_mens_anda_of_tr}}</b></span> Ofertas com transações em andamento. 
                              @else
                                  Existe <span style="color:rgb(197, 15, 233);"><b>{{$num_mens_anda_of_tr}}</b></span> Oferta com transações em andamento. 
                              @endif
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
                            @if(($num_ofp_parc > 1) or ($num_ofp_parc == 0))
                                Existem <span style="color:rgb(15, 135, 233);"><b>{{$num_ofp_parc}}</b></span> confirmações de Necessidades ou Trocas de outros participantes esperando sua finalização. 
                            @else
                                Existe <span style="color:rgb(15, 135, 233);"><b>{{$num_ofp_parc}}</b></span> confirmação de Necessidade ou Troca de outro participante esperando sua finalização. 
                            @endif
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
                              @if(($num_ofp_final > 1) or ($num_ofp_final == 0))
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
                          <h4 class="bi bi-chat-left-dots-fill texto-em-andamento"></h4>
                        </div>
                        <div class="col-11">
                          <p class="card-text" style="color:black;">
                            @if($num_mens_anda_nec > 1 or $num_mens_anda_nec == 0)
                               Existem <span style="color:rgb(197, 15, 233);"><b>{{$num_mens_anda_nec}}</b></span> Necessidades com transações em andamento. 
                            @else
                               Existe <span style="color:rgb(197, 15, 233);"><b>{{$num_mens_anda_nec}}</b></span> Necessidade com transações em andamento. 
                            @endif
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
                            @if($num_nec_parc > 1 or $num_nec_parc == 0 )
                               Existem <span style="color:rgb(15, 135, 233);"><b>{{$num_nec_parc}}</b></span> confirmações de Ofertas de outros participantes esperando sua finalização. 
                            @else
                               Existe <span style="color:rgb(15, 135, 233);"><b>{{$num_nec_parc}}</b></span> confirmação de Oferta de outro participante esperando sua finalização. 
                            @endif
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
                              @if($num_nec_final > 1 or $num_nec_final == 0)
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