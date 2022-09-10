@extends('master')

@section('content')

<div class="container-fluid">

    <h2 class="texto-necessidade">Necessidades do Participante</h2>
    <h5 class="texto-participante">{{$part->nome_part}}</h5>
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

    </div>

    <form class="row g-3" method="GET" action="{{route('consultar_necessidades_part')}}">

          @csrf

          <div class="col-sm-7">
               <input class="form-control texto_p" name="consulta_nec_part" value="{{Session::get('criterio_nec_part')}}" placeholder="Digite palavras para consulta..." type="search">
               <input name="id_part" type="hidden" value="{{$part->id}}">
          </div>

        <div class="col-sm">
          <button style="margin-right: 20px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
          <!--<a class="btn btn btn-redes bi-snow" type="button"> Incluir Rede</a> -->

          <!-- Button trigger modal -->
          @if(Session::get('id_logado') == $part->id)
            <button type="button" class="btn btn-incluir-necessidades btn-sm bi-arrow-up-circle-fill" data-bs-toggle="modal" data-bs-target="#Incluirnecessidade">
              Incluir Necessidade
            </button>
            <button type="button" class="btn btn-criar-necessidades btn-sm bi-arrow-up-circle-fill" data-bs-toggle="modal" data-bs-target="#Novanecessidade">
              Criar novo tipo de Necessidade
            </button>
          @endif
        </div>

    </form>

    <form action="{{route('incluir_necessidades_part')}}" method="post" enctype="multipart/form-data">

      @csrf

          <!-- Modal Incluir necessidade-->
          <div class="modal fade" id="Incluirnecessidade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Incluir Necessidade de : {{$part->nome_part}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                      <div class="modal-body">

                        <div class="row">
                          <!-- <div class="col-2">
                                <figure class="figure">
                                      <img id="imagem_nec" src="/img/logo.jpg" class="figure-img img-fluid imagem-of-nec img-thumbnail ">
                                </figure>
                          </div> -->

                          <div class="col-12" style="align-self: flex-end;">
                             <input id="sel_img" accept="image/*" data-msg-placeholder="Selecione uma imagem"
                                name="sel_img" type="file" class="file" data-browse-on-zone-click="true"
                                >
                              <!-- <input  name="sel_img" id="sel_img" type="file" accept=".jpg,.png,.jpeg" onchange ="mostra_imagem(this, 'inclusao',0)" class="form-control form-control-sm @error('sel_img') is-invalid @enderror" > -->
                              <label class="form-label red-message">{{Session::get('fail image')}}</label>
                          </div>

                        </div>

                        <div class="mb-3">

                          <input value="{{$part->id}}" name="id_part" type="hidden">

                          <label for="exampleFormControlInput1" class="form-label">Selecione um tipo de necessidade</label>
                          <select type="text" name="id_nec" id="exampleFormControlInput1" class="form-select" aria-label="Default select example" required>
                            <option value = ""></option>
                            @foreach ($necs as $nec)
                              <option value="{{$nec->id}}">
                                    {{$nec->descricao}}
                              </option>
                            @endforeach
                          </select>
                          <br>

                          <label for="data_nec" class="form-label">Data</label>
                          <input type="date" class="form-control" id="data_nec" name="data_nec" required>
                          <br>

                          <div class="row">
                               <div class="col">
                                    <label for="quant_nec" class="form-label">Quantidade</label>
                                    <input type="number" step="0.010" class="form-control" id="quant_nec" name="quant_nec" required>
                               </div>
                               <div class="col">
                                    <label for="id_rede" class="form-label">Vincular a Rede</label>
                                    <select id="id_rede" name="id_rede" class="form-select" aria-label="Default select example">
                                      <option selected></option>
                                      @foreach ($redes as $rede)
                                        <option value="{{$rede->id_rede}}">{{$rede->nome}}</option>
                                      @endforeach 
                                    </select>
                              </div>

                          </div>

                          <br>

                          <label for="obs_nec" class="form-label">Observações</label>
                          <textarea type="text" class="form-control" id="obs_nec" name="obs_nec"></textarea>
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

    <form action="{{route('nova_necessidade')}}" method="post">

      @csrf

    <!-- Modal Criar Nova necessidade -->
    <div class="modal fade" id="Novanecessidade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Criar novo tipo de Necessidade</h5>
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

    @if (isset($necps))

    <table class="table table-sm">
        <thead style="border-bottom: 1px solid black;">
          <tr>
            <th scope="col" class="texto_p">Imagem</th>
            <th scope="col" class="texto_p">Descrição</th>
            <th scope="col" class="texto_p">Data</th>
            <th scope="col" class="texto_p">Quant</th>
            <th scope="col" class="texto_p">Unidade</th>
            <th scope="col" class="texto_p" style="text-align:left;">Transações</th>
            <th scope="col" class="texto_p" >Status</th>

            @if(Session::get('id_logado') == $part->id)
                <th scope="col" class="texto_p" >Ações</th>
            @endif
          </tr>
        </thead>

        <tbody>
          @if (count($necps)>0)

              @foreach($necps as $necp)
                <div>
                  <tr>
                    <td>
                        <figure class="figure">

                          <div class="d-block d-lg-none d-md-none d-xl-none d-xxl-none">
                            @if(!@empty($necp->imagem))
                                <img id="imagem_nec_cons"  src="/uploads/nec_img/{{$necp->imagem}}" class="imagem-of-nec-cons-p">
                            @else
                                <img id="imagem_nec_cons" src="/img/logo.jpg" class="imagem-of-nec-cons-p">
                            @endif 
                          </div>

                          <div class="d-none d-sm-none d-md-block d-lg-block d-xl-block d-xxl-block">
                              @if(!@empty($necp->imagem))
                                  <img id="imagem_nec_cons"  src="/uploads/nec_img/{{$necp->imagem}}" class="imagem-of-nec-cons">
                              @else
                                  <img id="imagem_nec_cons" src="/img/logo.jpg" class="imagem-of-nec-cons">
                              @endif 
                          </div>

                      </figure>
            
                    </td>

                    <td>
                        <div class="col" style="width:auto;">
                          <h5 style="font-size:15px;"  class="card-title texto-necessidade">Necessidade : {{$necp->desc_nec}}</h5>
                          <h6 style="color:rgb(97, 75, 4)" class="card-subtitle mb-2 texto_m">Categoria : {{$necp->desc_cat}} </h6>
                          <p class="card-text texto_m">Obs : {{$necp->obs}}</p>
                        </div>
                    </td>

                    <td class="texto_p">
                      @if($necp->data)
                        @php
                          $date = new DateTime($necp->data);
                          echo $date->format('d-m-Y');
                        @endphp
                      @endif
                    </td>
                    <td class="texto_p">{{$necp->quant}}</td>
                    <td class="texto_p">{{$necp->desc_unid}}</td>

                   <!-- @if($necp->status == 2)
                        <td class="texto_p texto-em-andamento"><h4 class="bi bi-chat-left-dots-fill"></h4></td>
                    @else
                        @if(($necp->status == 3))
                            <td class="texto_p texto-parc-finalizada"><h4 class="bi bi-check-circle-fill"></h4></td>
                        @else
                            @if($necp->status == 4)
                                <td class="texto_p texto-finalizada"><h4 class="bi bi-check-circle-fill"></h4></td>
                            @else
                                <td class="texto_p"></td>
                            @endif
                        @endif
                    @endif -->

                    <td>
                      @if(Session::get('id_logado') == $part->id)
                        <form action="{{route('trans_necessidades_part')}}" method="get">
                              @csrf
                              <button type="submit" class="btn btn-sm btn-sugestoes bi-arrow-down-up texto_p">
                                Sugestões <span class="badge sugestao-of-nec">
                                          {{App\Http\Controllers\NecessidadesController::verifica_sugestoes_nec(Session::get('id_logado'),$necp->desc_cat,$necp->desc_nec,$necp->obs,1)}}
                                          </span>
                              </button>
                              <input value="true" name="filtra_id_logado" type="hidden">
                              <input value="{{$part->id}}" name="id_part_t" type="hidden">
                              <input value="{{$necp->id_nec_part}}" name="id_nec_part_t" type="hidden">
                        </form>
                      @else
                          <form action="{{route('trans_necessidades_part')}}" method="get">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-sugestoes bi-arrow-down-up texto_p">
                              Sugestões <span class="badge sugestao-of-nec">
                                        {{App\Http\Controllers\NecessidadesController::verifica_sugestoes_nec(Session::get('id_logado'),$necp->desc_cat,$necp->desc_nec,$necp->obs,0)}}
                                        </span>
                            </button>
                            <input value="0" name="filtra_id_logado" type="hidden">
                            <input value="{{$part->id}}" name="id_part_t" type="hidden">
                            <input value="{{$necp->id_nec_part}}" name="id_nec_part_t" type="hidden">
                          </form>
                      @endif
                    </td>

                    <td>
                      <div class="row">
                        <div class="col-1 texto-em-andamento">
                          <span >
                          @php
                             echo App\Http\Controllers\IniciaController::consulta_status_transacoes_nec_anda($necp->id_nec_part)
                          @endphp
                        </span>
                        </div>

                        <div class="col-2 texto-em-andamento d-none d-sm-none d-md-none d-lg-block d-xl-block d-xxl-block">
                          <h6 class="bi bi-chat-left-dots-fill"></h6>
                        </div>

                        <div class="col-1 texto-parc-finalizada">
                          <span >
                          @php
                             echo App\Http\Controllers\IniciaController::consulta_status_transacoes_nec_parc($necp->id_nec_part)
                          @endphp
                        </span>
                        </div>

                        <div class="col-2 texto-parc-finalizada d-none d-sm-none d-md-none d-lg-block d-xl-block d-xxl-block">
                          <h6 class="bi bi-check-circle-fill"></h6>
                        </div>

                        <div class="col-1 texto-finalizada">
                          <span >
                          @php
                             echo App\Http\Controllers\IniciaController::consulta_status_transacoes_nec_final($necp->id_nec_part)
                          @endphp
                        </span>
                        </div>

                        <div class="col-1 texto-finalizada d-none d-sm-none d-md-none d-lg-block d-xl-block d-xxl-block">
                          <h6 class="bi bi-check-circle-fill"></h6>
                        </div>

                      </div>
                    </td>

                    <td>
                        <div class="row">

                          <div class="col">

                            @if(Session::get('id_logado') == $part->id)
                              <button class="btn btn-editar btn-sm bi bi-pencil texto_p" type="submit" data-bs-toggle="modal" data-bs-target="#Editarnecessidade-{{$necp->id_nec_part}}"> Editar</button>
                            @endif

                            <form action="{{route('altera_necessidade_part')}}" method="post" enctype="multipart/form-data">
                              @csrf
                                <!-- Modal Alterar necessidade-->
                                <div class="modal fade" id="Editarnecessidade-{{$necp->id_nec_part}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Alterar Necessidade de : {{$part->nome_part}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                            <div class="modal-body">

                                              <div class="row">
                                                <div class="col-2">
                                                      <figure class="figure">

                                                        @if(!@empty($necp->imagem))
                                                            <img id="imagem_nec_alt-{{$necp->id_nec_part}}"  src="/uploads/nec_img/{{$necp->imagem}}" class="imagem-of-nec">
                                                        @else
                                                            <img id="imagem_nec_alt-{{$necp->id_nec_part}}" src="/img/logo.jpg" class="figure-img img-fluid imagem-of-nec img-thumbnail ">
                                                        @endif

                                                    </figure>

                                                </div>

                                                <div class="col-10" style="align-self: flex-end;">
                                                  <label for="sel_img_alt" class="form-label texto_m">Selecionar imagem</label>
                                                    <input  name="sel_img_alt" id="sel_img_alt" type="file" accept=".jpg,.png,.jpeg" onchange ="mostra_imagem(this,'editar',{{$necp->id_nec_part}})" class="form-control form-control-sm @error('sel_img_alt') is-invalid @enderror" >
                                                    <label class="form-label red-message">{{Session::get('fail image')}}</label>
                                                </div>

                                              </div>

                                              <div class="mb-3">
                                                <input value="{{$part->id}}" name="id_part" type="hidden">
                                                <input value="{{$necp->id_nec_part}}" name="id_nec_part" type="hidden">

                                                <label for="FormControl_id_nec" class="form-label">Selecione um tipo de Necessidade</label>
                                                <select type="text" name="id_nec" id="FormControl_id_nec" class="form-select" aria-label="Default select example" required>
                                                  <option value="{{$necp->id_nec}}" selected>{{$necp->desc_nec}}</option>
                                                  @foreach ($necs as $nec)
                                                    <option value="{{$nec->id}}">
                                                          {{$nec->descricao}}
                                                    </option>
                                                  @endforeach
                                                </select>
                                                <br>

                                                <div class="row">
                                                     <div class="col">
                                                          <label for="data_nec" class="form-label">Data</label>
                                                          <input type="date" value="{{$necp->data}}"  class="form-control" id="data_nec" name="data_nec" required>
                                                     </div>  
                                                     <div class="col">
                                                          <label for="id_rede_alt" class="form-label">Vinculada a Rede</label>
                                                          <select id="id_rede_alt" name="id_rede_alt" class="form-select" aria-label="Default select example">
                                                            <option selected value="{{$necp->id_rede}}"><?php echo $necp->nome_rede; ?></option>
                                                            @if($necp->id_rede > 0)
                                                              <option value="0"></option>       
                                                            @endif

                                                            @foreach ($redes as $rede)
                                                              @if($necp->id_rede <> $rede->id_rede)
                                                                <option value="{{$rede->id_rede}}">{{$rede->nome}}</option>  
                                                              @endif
                                                            @endforeach 
                                                          </select>
                                                    </div>  
                                                </div>

                                                
                                                <br>

                                                <label for="quant_nec" class="form-label">Quantidade</label>
                                                <input type="number" step="0.010" value="{{$necp->quant}}" class="form-control" id="quant_nec" name="quant_nec" required>

                                                <br>

                                                <label for="obs_nec" class="form-label">Observações</label>
                                                <textarea type="text" class="form-control" id="obs_nec" name="obs_nec" value="">{{$necp->obs}}</textarea>
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

                        </div>
                        
                        <div class="col">

                            @if(Session::get('id_logado') == $part->id)
                                <button class="btn btn-danger btn-sm bi bi-trash texto_p" type="button" data-bs-toggle="modal" data-bs-target="#ModalExcluinecessidade-{{$necp->id_nec_part}}" >Excluir</button>
                            @endif

                            <form class="" action="/deleta_necessidade_part/{{$necp->id_nec_part}}" method="POST">
                                  @csrf
                                  @method('DELETE')

                                  <!-- Modal -->
                                  <div class="modal fade" id="ModalExcluinecessidade-{{$necp->id_nec_part}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Confirma Exclusão da necessidade "{{$necp->desc_nec}}" para {{$part->nome_part}} ?</h5>
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

                        </div>
                        
                      </div>  

                    </td>

                  </tr>
                </div>

              @endforeach

          @else
              <td>Nenhum registro encontrado</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
          @endif

        </tbody>
      </table>

      <div class="pagination">
           {{$necps->links('layouts.paginationlinks')}}

      </div>

    @endif

<div>

  <script>

    function mostra_imagem(input,$modo,$id_nec_part){

             if (input.files && input.files[0]) {

               var reader = new FileReader();

               reader.onload = function (e) {
                     if($modo == 'inclusao'){
                       $('#imagem_nec').attr('src', e.target.result);
                     }else{
                       if($modo == 'editar'){
                          $('#imagem_nec_alt-' + $id_nec_part).attr('src', e.target.result);

                       }
                     }

               };
               reader.readAsDataURL(input.files[0]);

             }

    }

 </script>

@endsection


