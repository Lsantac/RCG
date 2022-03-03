@extends('master')

@section('content')



<div class="container-fluid">

    <h2 class="texto-oferta">Ofertas do Participante</h2> 
    <h5 class="texto-nome-logado">{{$part->nome_part}}</h5> 
    <br>

    <div class='results'>
      @if(Session::get('success'))
          <div class="alert alert-success">
              {{Session::get('success')}}
          </div>
      @endif

      @if(Session::get('fail'))
          <div class="alert alert-danger">
              {{Session::get('fail')}}
          </div>
      @endif

      @if(Session::get('fail type'))
          <div class="alert alert-danger">
              {{Session::get('fail type')}}
          </div>
      @endif

      @if(Session::get('fail size'))
          <div class="alert alert-danger">
              {{Session::get('fail size')}}
          </div>
      @endif

    </div>

    <form class="row g-3" method="get" action="{{route('consultar_ofertas_part')}}">

          @csrf
     
          <div class="col-sm-8">
               <input class="form-control texto_m" name="consulta_of_part" value="{{Session::get('criterio_of_part')}}" placeholder="Digite palavras para consulta..." type="search">
               <input name="id_part" type="hidden" value="{{$part->id}}"> 
          </div>
      
        <div class="col-sm">
          <button style="margin-right: 20px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
          <!--<a class="btn btn btn-redes bi-snow" type="button"> Incluir Rede</a> -->
          
          <!-- Button trigger modal -->
              
              @if(Session::get('id_logado') == $part->id)  
                <button type="button" class="btn btn-incluir-ofertas btn-sm bi-arrow-up-circle-fill" data-bs-toggle="modal" data-bs-target="#IncluirOferta">
                  Incluir Oferta
                </button>

                <button type="button" class="btn btn-criar-ofertas btn-sm bi-arrow-up-circle-fill" data-bs-toggle="modal" data-bs-target="#NovaOferta">
                  Criar novo tipo de Oferta
                </button>
              @endif 
          
        </div>
        
    </form>

    <form action="{{route('incluir_ofertas_part')}}" method="post" enctype="multipart/form-data">

         @csrf
      
          <!-- Modal Incluir Oferta-->
          <div class="modal fade" id="IncluirOferta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Incluir Oferta de : {{$part->nome_part}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                      <div class="modal-body">

                        <div class="row">
                          <div class="col-2">
                                <figure class="figure">
                                      <img id="imagem_of" src="/img/logo.jpg" class="figure-img img-fluid imagem-of-nec img-thumbnail ">
                                </figure>
                          </div>

                          <div class="col-10" style="align-self: flex-end;">
                             <label for="sel_img" class="form-label texto_m">Selecionar imagem</label>
                              <input  name="sel_img" id="sel_img" type="file" accept=".jpg,.png,.jpeg" onchange ="mostra_imagem(this, 'inclusao',0)" class="form-control form-control-sm @error('sel_img') is-invalid @enderror" >
                              <label class="form-label red-message">{{Session::get('fail image')}}</label>
                          </div>
                         
                        </div>

                        <div class="mb-3">

                          <input value="{{$part->id}}" name="id_part" type="hidden">
                          
                          <label for="exampleFormControlInput1" class="form-label">Selecione um tipo de Oferta</label>
                          <select type="text" name="id_of" id="exampleFormControlInput1" class="form-select" aria-label="Default select example" required>
                            <option value = ""></option>
                            @foreach ($ofs as $of)
                              <option value="{{$of->id}}"> 
                                    {{$of->descricao}} 
                              </option>
                            @endforeach
                          </select>
                          <br>

                          <label for="data_of" class="form-label">Data</label>
                          <input type="date" class="form-control" id="data_of" name="data_of" required>
                          <br>

                          <label for="quant_of" class="form-label">Quantidade</label>
                          <input type="number" step="0.010" class="form-control" id="quant_of" name="quant_of" required>

                          <br>

                          <label for="obs_of" class="form-label">Observações</label>
                          <textarea type="text" class="form-control" id="obs_of" name="obs_of" required></textarea>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-sair" data-bs-dismiss="modal">Sair</button>
                      <button type="submit" class="btn btn-primary">Incluir</button>
                    </div>
              </div>
            </div>
          </div>
    </form>

    <form action="{{route('nova_oferta')}}" method="post">
      
      @csrf

    <!-- Modal Criar Nova Oferta -->
    <div class="modal fade" id="NovaOferta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Criar novo tipo de Oferta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
          <div class="modal-body">
               <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="descricao" required>
              </div>
              <div class="mb-3">
                <label for="categoria" class="form-label">Selecione uma Categoria</label>
                <select type="text" name="categoria" id="categoria" class="form-select" aria-label="Default select example" required>
                  <option value = ""></option>
                  @foreach ($cats as $cat)
                    <option value="{{$cat->id}}"> 
                          {{$cat->descricao}} 
                    </option>
                  @endforeach
                </select>
                <br>
                <label for="unidade" class="form-label">Selecione uma Unidade</label>
                <select type="text" name="unidade" id="unidade" class="form-select" aria-label="Default select example" required>
                  <option value = ""></option>
                  @foreach ($unids as $unid)
                    <option value="{{$unid->id}}"> 
                          {{$unid->descricao}} 
                    </option>
                  @endforeach
                </select>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sair" data-bs-dismiss="modal">Sair</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </div>
      </div>
    </div>

    </form>

    <br>

    @if (isset($ofps)) 

    <table  class="table table-sm">
        <thead style="border-bottom: 1px solid black;">
          <tr>
            <th scope="col" class="texto_p">Descrição</th>
            <!--<th scope="col" class="texto_p">Categoria</th>-->
            <th scope="col" class="texto_p">Data</th>
            <th scope="col" class="texto_p">Quant</th>
            <th scope="col" class="texto_p">Unidade</th>
            <th scope="col" class="texto_p">Transações</th>
            <th scope="col" class="texto_p">Status</th>
            
            @if(Session::get('id_logado') == $part->id)  
                <th scope="col" class="texto_p" >Ações</th>
            @endif
            
          </tr>
        </thead>

        <tbody>
          @if (count($ofps)>0)

              @foreach($ofps as $ofp)
                <div>
                  <tr>
                    <td>
                      <div class="" style="width:50rem;">
                        <div class="">

                          <div class="row">
                            <div class="col-1" >
                                <figure class="figure">
                    
                                  @if(!@empty($ofp->imagem))
                                      <img id="imagem_of_cons"  src="/uploads/of_img/{{$ofp->imagem}}" class="imagem-of-nec-cons">
                                  @else
                                      <img id="imagem_of_cons" src="/img/logo.jpg" class="imagem-of-nec-cons">
                                  @endif 
                          
                              </figure>
                            </div>

                            <div class="col" style="padding-left: 30px;">
                                <h5 style="font-size:15px;"  class="card-title texto-oferta">Oferta : {{$ofp->desc_of}}</h5>
                                <h6 style="color:rgb(4, 97, 97)" class="card-subtitle mb-2 texto_m">Categoria : {{$ofp->desc_cat}} </h6>
                                <p class="card-text texto_m">Obs : {{$ofp->obs}}</p>    
                            </div>
                            
                          </div>

                        </div>
                      </div>
                    </td>

                    <!--<td class="texto_p">{{$ofp->desc_of}}</td>
                    <td class="texto_p">{{$ofp->desc_cat}}</td>-->
                    <td class="texto_p">
                      @if($ofp->data)
                          @php
                              $date = new DateTime($ofp->data);
                              echo $date->format('d-m-Y');
                          @endphp
                       @endif
                    </td>
                    <td class="texto_p">{{$ofp->quant}}</td>
                    <td class="texto_p">{{$ofp->desc_unid}}</td>
                   
                    
                  <!--  @if($ofp->status == 2)
                        <td class="texto_p texto-em-andamento"><h4 class="bi bi-chat-left-dots-fill"></h4></td>
                    @else
                        @if(($ofp->status == 3))
                            <td class="texto_p texto-parc-finalizada"><h4 class="bi bi-check-circle-fill"></h4></td>
                        @else 
                            @if($ofp->status == 4)
                                <td class="texto_p texto-finalizada"><h4 class="bi bi-check-circle-fill"></h4></td>
                            @else  
                                <td class="texto_p"></td>
                            @endif
                        @endif  
                    @endif -->

                    

                    <td>
                        @if(Session::get('id_logado') == $part->id)  

                            <form action="{{route('trans_ofertas_part')}}" method="get">
                                  @csrf 
                                  <button type="submit" class="btn btn-sm btn-sugestoes bi-arrow-down-up texto_p">
                                    Sugestões <span class="badge sugestao-of-nec">
                                                  @if(Session::get('id_logado') == $part->id)
                                                    {{App\Http\Controllers\OfertasController::verifica_sugestoes_of(Session::get('id_logado'),$ofp->desc_cat,$ofp->desc_of,$ofp->obs,true)}}
                                                  @else
                                                    <!--{{App\Http\Controllers\OfertasController::verifica_sugestoes_of(Session::get('id_logado'),$ofp->desc_cat,$ofp->desc_of,$ofp->obs,false)}}-->
                                                  @endif
                                              </span>
                                  </button>
                                  
                                  @if(Session::get('id_logado') == $part->id)
                                    <input value="true" name="filtra_id_logado" type="hidden">
                                    <input value="{{$part->id}}" name="id_part_t" type="hidden">   
                                    <input value="" name="nome_part_cab" type="hidden">   
                                  @else
                                    <input value="false" name="filtra_id_logado" type="hidden">
                                    <input value="{{Session::get('id_logado')}}" name="id_part_t" type="hidden">
                                    <input value="{{$part->nome_part}}" name="nome_part_cab" type="hidden">   
                                  @endif 
                                  <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden">
                            </form>
                        @else

                            <form action="{{route('trans_trocas_part')}}" method="get">
                                  @csrf 
                                  <input value="{{$ofp->id_part}}" name="id_part_t" type="hidden">
                                  <input value="{{$ofp->id_of_part}}" name="id_of_part_t" type="hidden">
                                  <input value="false" name="filtra_id_logado" type="hidden">
                                  <input value="{{Session::get('id_logado')}}" name="id_logado" type="hidden">

                                  <p><button type="submit" class="btn btn-sm btn-trocar bi-arrow-repeat texto_p">&nbspTrocar</button></p>   
                            </form>

                        @endif

                    </td>

                    <td>
                      <div class="row">
                        <div class="col-1 texto-em-andamento">
                          <span>
                          @php
                             echo App\Http\Controllers\IniciaController::consulta_status_transacoes_of_anda($ofp->id_of_part)
                          @endphp  
                        </span>
                        </div>

                        <div class="col-2 texto-em-andamento">
                          <h6 class="bi bi-chat-left-dots-fill"></h6>
                        </div>

                        <div class="col-1 texto-parc-finalizada">
                          <span >
                          @php
                             echo App\Http\Controllers\IniciaController::consulta_status_transacoes_of_parc($ofp->id_of_part)
                          @endphp  
                        </span>
                        </div>

                        <div class="col-2 texto-parc-finalizada">
                          <h6 class="bi bi-check-circle-fill"></h6>
                        </div>

                        <div class="col-1 texto-finalizada">
                          <span >
                          @php
                             echo App\Http\Controllers\IniciaController::consulta_status_transacoes_of_final($ofp->id_of_part)
                          @endphp  
                        </span>
                        </div>

                        <div class="col-1 texto-finalizada">
                          <h6 class="bi bi-check-circle-fill"></h6>
                        </div>

                      </div>
                    </td>
                    
                    <td>
                        @if(Session::get('id_logado') == $part->id)  
                           <button class="btn btn-editar btn-sm bi bi-pencil texto_p" type="submit" data-bs-toggle="modal" data-bs-target="#EditarOferta-{{$ofp->id_of_part}}">
                            Editar</button>
                        @endif  

                        <form action="{{route('altera_oferta_part')}}" method="post" enctype="multipart/form-data">
                          @csrf 
                            <!-- Modal Alterar Oferta-->
                            <div class="modal fade" id="EditarOferta-{{$ofp->id_of_part}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Alterar Oferta de : {{$part->nome_part}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                        <div class="modal-body">

                                          <div class="row">
                                            <div class="col-2">
                                                  <figure class="figure">
                  
                                                    @if(!@empty($ofp->imagem))
                                                        <img id="imagem_of_alt-{{$ofp->id_of_part}}"  src="/uploads/of_img/{{$ofp->imagem}}" class="imagem-of-nec">
                                                    @else
                                                        <img id="imagem_of_alt-{{$ofp->id_of_part}}" src="/img/logo.jpg" class="figure-img img-fluid imagem-of-nec img-thumbnail ">
                                                    @endif 
                                            
                                                 </figure>
                                                 
                                            </div>
                  
                                            <div class="col-10" style="align-self: flex-end;">
                                               <label for="sel_img_alt" class="form-label texto_m">Selecionar imagem</label>
                                                <input  name="sel_img_alt" id="sel_img_alt" type="file" accept=".jpg,.png,.jpeg" onchange ="mostra_imagem(this,'editar',{{$ofp->id_of_part}})" class="form-control form-control-sm @error('sel_img_alt') is-invalid @enderror" >
                                                <label class="form-label red-message">{{Session::get('fail image')}}</label>
                                            </div>
                                           
                                          </div>

                                          <div class="mb-3">
                                            <input value="{{$part->id}}" name="id_part" type="hidden">
                                            <input value="{{$ofp->id_of_part}}" name="id_of_part" type="hidden">
                                            
                                            
                                            <label for="FormControl_id_of" class="form-label">Selecione um tipo de Oferta</label>
                                            <select type="text" name="id_of" id="FormControl_id_of" class="form-select" aria-label="Default select example" required>
                                              <option value="{{$ofp->id_of}}" selected>{{$ofp->desc_of}}</option>
                                              @foreach ($ofs as $of)
                                                <option value="{{$of->id}}"> 
                                                      {{$of->descricao}} 
                                                </option>
                                              @endforeach
                                            </select>
                                            <br>
                  
                                            <label for="data_of" class="form-label">Data</label>
                                            <input type="date" value="{{$ofp->data}}"  class="form-control" id="data_of" name="data_of" required>
                                            <br>
                  
                                            <label for="quant_of" class="form-label">Quantidade</label>
                                            <input type="number" step="0.010" value="{{$ofp->quant}}" class="form-control" id="quant_of" name="quant_of" required>
                  
                                            <br>
                  
                                            <label for="obs_of" class="form-label">Observações</label>
                                            <textarea type="text" class="form-control" id="obs_of" name="obs_of" value="">{{$ofp->obs}}</textarea>
                                          </div>
                                          
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-sair" data-bs-dismiss="modal">Sair</button>
                                        <button type="submit" class="btn btn-primary">Alterar</button>
                                      </div>
                                </div>
                              </div>
                            </div>
                          </form>
                    </td>
                    <td>
                        @if(Session::get('id_logado') == $part->id)  
                            <button class="btn btn-danger btn-sm bi bi-trash texto_p" type="button" data-bs-toggle="modal" data-bs-target="#ModalExcluiOferta-{{$ofp->id_of_part}}" >
                             Excluir</button>
                        @endif

                        <form class="" action="/deleta_oferta_part/{{$ofp->id_of_part}}" method="POST">
                              @csrf
                              @method('DELETE')
                          
                              <!-- Modal -->
                              <div class="modal fade" id="ModalExcluiOferta-{{$ofp->id_of_part}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Confirma Exclusão da Oferta "{{$ofp->desc_of}}" para {{$part->nome_part}} ?</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                   
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Sair</button>
                                      <button type="submit" class="btn btn-danger">Excluir</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </form>
                    </td>
                    
                  </tr>
                  
                </div>
                
                
              @endforeach

          @else
              <td><td>Nenhum registro encontrado</td></td>    
              
          @endif 

        </tbody>
      </table>

      <div class="pagination">
           {{$ofps->links('layouts.paginationlinks')}}
           
      </div>

    @endif 

<div>

  <script>
     
     function mostra_imagem(input,$modo,$id_of_part){

              if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function (e) {
                      if($modo == 'inclusao'){
                        $('#imagem_of').attr('src', e.target.result);
                      }else{
                        if($modo == 'editar'){
                           $('#imagem_of_alt-' + $id_of_part).attr('src', e.target.result);
                           
                        }
                      }
                      
                };
                reader.readAsDataURL(input.files[0]);
                
              }

     }

  </script>

@endsection


