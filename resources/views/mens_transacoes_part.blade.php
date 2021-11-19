@extends('master')

@section('content')

<div class="container">

  <div class="row">
    <div class="col-6">
         <h4 class="texto-oferta" style="color:rgb(91, 19, 207);">Detalhes da Transação</h4>      
    </div>
  </div>

  <br>

  <div class="row">
    <div class="col">

        <div class="card">
          <h6 class="card-header header-oferta">Oferta : {{$ofps->desc_of}}</h6>
          <div class="card-body">
            <h6 class="card-title">{{$ofps->nome_part}}</h6>
            <div class="card-text texto_m">Categoria : {{$ofps->desc_cat}}</div>
            <div class="card-text texto_m">Quant inicial : {{$ofps->quant}}  {{$ofps->desc_unid}}</div>

            @if($disp_qt_of_trans > 0)
               <div style="color: blue;" class="card-text texto_m">Quant disponivel : {{$disp_qt_of_trans}}  {{$ofps->desc_unid}}</div>
            @else
               <div style="color: red;" class="card-text texto_m">Quant disponivel : {{$disp_qt_of_trans}}  {{$ofps->desc_unid}}</div>
            @endif
            
            <div class="card-text texto_m">Obs : {{$ofps->obs}}</div>
            <br>
            <div class="row">
                <div class="col-3">
                  <a href="#" class="btn btn-primary btn-sm">Ver Perfil</a>    
                </div>
                <div class="col-9">
                  <div style="color:rgb(13, 122, 13); text-decoration:double;" class="card-text texto_m"> 
                    <strong> Confirmada em :
                      @php
                      if(isset($trans[0])){
                        if($trans[0]->data_final_of_part > 0){
                          $date = new DateTime($trans[0]->data_final_of_part);
                          echo $date->format('d-m-Y'). " (UTC: ".$date->format('H:i').")" ;
                        }
                      }
                      @endphp
                    </strong>
                  </div>
                  
                </div>
                
            </div>
            
          </div>
        </div>

    </div>

    <div class="col">
      <div class="card">
        @if(isset($necps))
            <h6 class="card-header header-necessidade">Necessidade : {{$necps->desc_nec}}</h6>
            <div class="card-body">
              <h6 class="card-title">{{$necps->nome_part}}</h6>
              <div class="card-text texto_m">Categoria : {{$necps->desc_cat}}</div>
              <div class="card-text texto_m">Quant inicial : {{$necps->quant}}  {{$necps->desc_unid}}</div>
              @if($disp_qt_nec_trans > 0)
                <div style="color: blue;" class="card-text texto_m">Quant disponivel : {{$disp_qt_nec_trans}}  {{$necps->desc_unid}}</div>
              @else
                <div style="color: red;" class="card-text texto_m">Quant disponivel : {{$disp_qt_nec_trans}}  {{$necps->desc_unid}}</div>
              @endif
              <div class="card-text texto_m">Obs : {{$necps->obs}}</div>
              <br>
              <div class="row">
                <div class="col-3">
                  <a href="#" class="btn btn-primary btn-sm">Ver Perfil</a>    
                </div>
                <div class="col-9">
                  <div style="color:rgb(122, 66, 13); text-decoration:double;" class="card-text texto_m"> 
                    <strong> Confirmada em :
                    @php
                          
                        if(isset($trans[0])){
                          if($trans[0]->data_final_nec_part > 0){
                            $date = new DateTime($trans[0]->data_final_nec_part);
                            echo $date->format('d-m-Y'). " (UTC: ".$date->format('H:i').")" ;
                          }
                        }
                        
                    @endphp

                    </strong>
                  </div>
                </div>
            </div>
        @else
            <h6 class="card-header header-troca">Oferta Troca : {{$oftrps->desc_of}}</h6>
            <div class="card-body">
              <h6 class="card-title">{{$oftrps->nome_part}}</h6>
              <div class="card-text texto_m">Categoria : {{$oftrps->desc_cat}}</div>
              <div class="card-text texto_m">Quant inicial : {{$oftrps->quant}}  {{$oftrps->desc_unid}}</div>
              @if($disp_qt_of_tr_trans > 0)
                <div style="color: blue;" class="card-text texto_m">Quant disponivel : {{$disp_qt_of_tr_trans}}  {{$oftrps->desc_unid}}</div>
              @else
                <div style="color: red;" class="card-text texto_m">Quant disponivel : {{$disp_qt_of_tr_trans}}  {{$oftrps->desc_unid}}</div>
              @endif
              <div class="card-text texto_m">Obs : {{$oftrps->obs}}</div>
              <br>
              <div class="row">
                <div class="col-3">
                  <a href="#" class="btn btn-primary btn-sm">Ver Perfil</a>    
                </div>
                <div class="col-9">
                  <div style="color:rgb(122, 66, 13); text-decoration:double;" class="card-text texto_m"> 
                    <strong> Confirmada em :
                        @php
                            if(isset($trans[0])){
                              if($trans[0]->data_final_of_tr_part > 0){
                                $date = new DateTime($trans[0]->data_final_of_tr_part);
                                echo $date->format('d-m-Y'). " (UTC: ".$date->format('H:i').")" ;
                              }
                            }
                        @endphp
                    </strong>
                  </div>
                </div>
            </div>
        @endif

        </div>
      </div>
    </div>

    <div class="col">

      <div class="card">
        <h6 class="card-header header-trans">Definições</h6>
        <div class="card-body">

            <div class="row texto_m">
              <div class="col-4">
                <label for="inputMoeda" class="">Fluxo :</label>
              </div>

              <div class="col-6 ">
                @if(isset($oftrps))
                    <input  class="form-control" value="Troca" name="Fluxo" id="Fluxo" readonly>
                @else 
                    <select form="finalizar_transacao" class="form-select texto_m" aria-label="Default select example" name="Fluxo" id="Fluxo" required>
                            @if (count($trans)>0)
                              <option value="{{$trans[0]->id_moeda}}" selected>{{$trans[0]->desc_moeda}}</option>
                            @else
                              <option value = "" selected></option>
                            @endif
                            @foreach ($moedas as $moeda)
                              <option value="{{$moeda->id}}"> 
                                    {{$moeda->desc_moeda}} 
                              </option>
                            @endforeach
                    </select>
                @endif
              </div>
            </div>
              <br> 

              <div class="row texto_m">
                <div class="col-4">
                  <label for="inputQtMoeda" class="">Qt Fluxo :</label>
                </div>
  
                <div class="col-4 ">
                  @if (count($trans)>0)
                      <input onkeypress="return event.keyCode!=13" id="QtFluxo" form="finalizar_transacao" value="{{$trans[0]->quant_moeda}}"  type="" name="QtFluxo" class="form-control texto_m"  required>
                  @else
                      <input onkeypress="return event.keyCode!=13" id="QtFluxo" form="finalizar_transacao" value="1"  type="" name="QtFluxo" class="form-control texto_m"  required>
                  @endif
                </div>
              </div>


              <div class="row texto_m">
                <div class="col-4">
                  <label for="inputQtOf" class="">Qt Oferta :</label>
                </div>
  
                <div class="col-8 ">
                  <div class="row">
                    <div class="col-6 ">
                         @if (count($trans)>0)
                             <input onkeypress="return event.keyCode!=13" id="QtOf" name="QtOf" onchange="verifica_quant({{$disp_qt_of_trans}},'of')"  form="finalizar_transacao"  value="{{$trans[0]->quant_of}}" type=""  class="form-control texto_m"  required>  
                         @else
                             <input onkeypress="return event.keyCode!=13" id="QtOf" name="QtOf" onchange="verifica_quant({{$disp_qt_of_trans}},'of')" form="finalizar_transacao"  value="{{$disp_qt_of_trans}}" type=""  class="form-control texto_m"  required>  
                         @endif    
                    </div>
                    <div class="col-3" style="padding: 5px 0;border: 3px;">{{$ofps->desc_unid}}</div>
                  </div>

                </div>
              </div>

              <div class="row texto_m">
                @if(isset($necps))
                    <div class="col-4">
                      <label for="inputQtNec" class="">Qt Necessidade :</label>
                    </div>
      
                    <div class="col-8 ">
                      <div class="row">
                          <div class="col-6 ">
                            @if (count($trans)>0)
                                <input  onkeypress="return event.keyCode!=13" id="QtNec" name="QtNec" onchange="verifica_quant({{$disp_qt_nec_trans}},'nec')" form="finalizar_transacao"  value="{{$trans[0]->quant_nec}}" type=""  class="form-control texto_m"  required>  
                            @else
                                <input  onkeypress="return event.keyCode!=13" id="QtNec" name="QtNec" onchange="verifica_quant({{$disp_qt_nec_trans}},'nec')" form="finalizar_transacao"  value="{{$disp_qt_nec_trans}}" type=""  class="form-control texto_m"  required>  
                            @endif  
                          </div>
                          <div class="col-3" style="padding: 5px 0;border: 3px;">{{$necps->desc_unid}}</div>
                          
                      </div>
                    </div>
                  </div>
                @else
                    <div class="col-4">
                      <label for="inputQtOfTr" class="">Qt Oferta troca :</label>
                    </div>
      
                    <div class="col-8 ">
                      <div class="row">
                          <div class="col-6 ">
                            @if (count($trans)>0)
                                <input  onkeypress="return event.keyCode!=13" id="QtOfTr" name="QtOfTr" onchange="verifica_quant({{$disp_qt_of_tr_trans}},'tr')" form="finalizar_transacao"  value="{{$trans[0]->quant_of_tr}}" type=""  class="form-control texto_m"  required>  
                            @else
                                <input  onkeypress="return event.keyCode!=13" id="QtOfTr" name="QtOfTr" onchange="verifica_quant({{$disp_qt_of_tr_trans}},'tr')" form="finalizar_transacao"  value="{{$disp_qt_of_tr_trans}}" type=""  class="form-control texto_m"  required>  
                            @endif  
                          </div>
                          <div class="col-3" style="padding: 5px 0;border: 3px;">{{$oftrps->desc_unid}}</div>
                          
                      </div>
                    </div>
                  </div>
                @endif


              <!-- Modal -->
              <form id='finalizar_transacao'  action="{{route('finalizar_transacao')}}" method="get">
                
                @csrf

                <!-- Button trigger modal Finalizar -->
                <button type="button" class="btn btn-finalizar btn-sm" data-bs-toggle="modal" data-bs-target="#finalizar">
                  Finalizar
                </button>

                <div class="modal fade" id="finalizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Finalizar Transação?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                         Concorda com os termos combinados nas mensagens e nas definições da transação? 
                         <br>
                         Para que a transação seja concluida completamente, é preciso que as duas partes confirmem. 
                      </div>

                      <input value="{{Session('id_logado')}}" name="id_logado" id="id_logado" type="hidden">
                      <input value="{{$ofps->id_part}}" name="id_part_of" id="id_part_of" type="hidden">
                      <input value="{{$ofps->id_of_part}}" name="id_of_part_t" id="id_of_part_t" type="hidden">

                      <input value="{{$disp_qt_of_trans}}" name="disp_qt_of_trans" id="disp_qt_of_trans" type="hidden">
                      <input value="{{$disp_qt_of_tr_trans}}" name="disp_qt_of_tr_trans" id="disp_qt_of_tr_trans" type="hidden">
                      <input value="{{$disp_qt_nec_trans}}" name="disp_qt_nec_trans" id="disp_qt_nec_trans" type="hidden">

                      @if(isset($oftrps))
                         <input value="{{$oftrps->id_part}}" name="id_part_of_tr" id="id_part_of_tr" type="hidden">
                         <input value="{{$oftrps->id_of_part}}" name="id_of_tr_part_t" id="id_of_tr_part_t" type="hidden">
                         <input value="0" name="id_nec_part_t" id="id_nec_part_t" type="hidden">
                      @else
                         <input value="{{$necps->id_part}}" name="id_part_nec" id="id_part_nec" type="hidden">
                         <input value="{{$necps->id_nec_part}}" name="id_nec_part_t" id="id_nec_part_t" type="hidden">
                         <input value="0" name="id_of_tr_part_t" id="id_of_tr_part_t" type="hidden">
                      @endif
                      
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Sair</button>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                      </div>
                    </div>
                  </div>
                </div>

              </form>  

        </div>
      </div>

    </div>
  </div>

    <br>
    <div class="row">
        <div class="col-2">
            <h5 class="texto-mensagens">Mensagens : </h5> 
        </div>
        <div class="col">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Nova Mensagem
              </button>

              <!-- Modal -->
              <form action="{{route('incluir_mensagem')}}" method="get">
                
                @csrf
               
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header cab-msg">
                        @if(isset($necps))
                            <h5 class="modal-title" id="staticBackdropLabel">Nova mensagem para : {{$necps->nome_part}}</h5>
                        @else
                            <h5 class="modal-title" id="staticBackdropLabel">Nova mensagem para : {{$ofps->nome_part}}</h5>
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <div class="texto-oferta">Oferta : {{$ofps->desc_of}}</div>
                          @if(isset($necps))
                              <div class="texto-necessidade">Necessidade : {{$necps->desc_nec}}</div>
                          @else
                              <div class="texto-troca">Oferta Troca : {{$oftrps->desc_of}}</div>
                          @endif

                          <br>
                          <textarea name ="mensagem" class="form-control" id="mensagem" rows="3" required></textarea>

                          <input value="{{Session('id_logado')}}" name="id_part_logado" id="id_part_logado" type="hidden">
                          <input value="{{$ofps->id_of_part}}" name="id_of_part_t" id="id_of_part_t" type="hidden">
                          <input value="{{$ofps->quant}}" name="qt_of_part_t" id="qt_of_part_t" type="hidden">
                        
                          @if(isset($oftrps) )
                             <input value="{{$oftrps->id_of_part}}" name="id_of_tr_part_t" id="id_of_tr_part_t" type="hidden">
                             <input value="0" name="id_nec_part_t" id="id_nec_part_t" type="hidden">
                             <input value="{{$oftrps->quant}}" name="qt_of_tr_part_t" id="qt_of_tr_part_t" type="hidden">
                          @else
                             <input value="{{$necps->id_nec_part}}" name="id_nec_part_t" id="id_nec_part_t" type="hidden">
                             <input value="0" name="id_of_tr_part_t" id="id_of_tr_part_t" type="hidden">
                             <input value="{{$necps->quant}}" name="qt_nec_part_t" id="qt_nec_part_t" type="hidden">   
                          @endif

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Sair</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                      </div>
                    </div>
                  </div>
                </div>

              </form>
        </div>
    </div>
    <br>

    @if (isset($msgs)) 

    <table class="table table-sm">
        <thead class="cab-msg">
          <tr>
            <th scope="col" class="texto_m">Data</th>
            <th scope="col" class="texto_m">Enviado por</th>
            <th scope="col" class="texto_m">Mensagem</th>
            <th class="texto_m" colspan="3">Ações</th>
          </tr>
        </thead>

        <tbody>
          @if (count($msgs)>0)

              @foreach($msgs as $msg)
                 
                 <tr>
                    <td class="texto_m">
                      @php
                          $date = new DateTime($msg->data);
                          echo $date->format('d-m-Y'). " (UTC: ".$date->format('H:i').")" ;
                      @endphp
                    </td>

                    <td class="texto_m ">{{$msg->nome_part_mens}}</td>
                    <td class="texto_m ">{{$msg->mensagem}}</td>

                </tr>
              @endforeach

          @else
              <td class="texto_m">Nenhum registro encontrado</td>    
              <td></td>
              <td></td>
              <td></td>
          @endif 

        </tbody>
      </table>

      
    @endif 

    <div class="pagination">
        {{$msgs->links('layouts.paginationlinks')}}
    </div>
   
<div>
 
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
      <div id="myToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header btn-finalizar">
          Mensagem
        </div>
        <div class="toast-body">
          @if(Session::has('code'))
              @if (Session::get('code') == 3) 
                  Transação Finalizada Parcialmente!
              @else
                  @if (Session::get('code') == 4)
                    Transação Finalizada Totalmente!
                  @else
                    @if (Session::get('code') == 1) 
                        Transação não pode ser finalizada ainda! Não existem ainda mensagens entre os participantes!
                    @endif    
                  @endif
              @endif
          @endif
             
        </div>
      </div>
  </div>

 <!-- Modal de alerta de quantidades -->
<div class="modal" id="ModalAlertQt">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Atenção!</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div  class="modal-body">
        <p id="ModalTextoQt">Quantidade maior do que a disponivel. </p> 
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Ok</button>
      </div>

    </div>
  </div>
</div>
 
  
@if (Session::has('code') && Session::get('code') <> 0) 
    
    <script>
     $(document).ready(function(){
        $("#myToast").toast("show");
   
     });
     
    </script>
@endif 

@if(Session('id_logado') == $ofps->id_part )
   <script>
       document.getElementById("QtOf").readOnly = false ;
       document.getElementById("QtNec").readOnly = true;
   </script>
@else
   @if(isset($necps))
       @if(Session('id_logado') == $necps->id_part )
           <script>
               document.getElementById("QtOf").readOnly = true  ;
               document.getElementById("QtNec").readOnly = false ;
           </script>
       @endif
   @else
        @if(Session('id_logado') == $oftrps->id_part )
        <script>
            document.getElementById("QtOf").readOnly = true  ;
            document.getElementById("QtOfTr").readOnly = false ;
        </script>
        @endif 
   @endif    
@endif

<script>
  
  function verifica_quant(quant_disp,of_tr_nec) {

    var quant_of = document.getElementById("QtOf").value;
    var quant_nec = document.getElementById("QtNec").value;
        
    /*var quant_tr = document.getElementById("QtOf").value;*/
    
    if(of_tr_nec == 'of'){
      if(quant_of > quant_disp){
          document.getElementById("ModalTextoQt").innerHTML = "Quantidade digitada é maior do que a quantidade disponivel da oferta!";
          $("#ModalAlertQt").modal("show");
          document.getElementById("QtOf").value = 0;
      }   
    }else{
      if(of_tr_nec == 'nec'){
        if(quant_nec > quant_disp){
          document.getElementById("ModalTextoQt").innerHTML = "Quantidade digitada é maior do que a quantidade disponivel da necessidade!";
          $("#ModalAlertQt").modal("show");
          document.getElementById("QtNec").value = 0;
        }   
      }else{
        if(of_tr_nec == 'tr'){
          if(quant_of_tr > quant_disp){
            document.getElementById("ModalTextoQt").innerHTML = "Quantidade digitada é maior do que a quantidade disponivel da Oferta da troca!";
            $("#ModalAlertQt").modal("show");
            document.getElementById("QtOfTr").value = 0;
          }   
        }
      }
    }
    
  }
   
  </script>



@endsection


