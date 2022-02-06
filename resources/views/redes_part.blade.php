@extends('master')

@section('content')

<div class="container-fluid">

    <h2 style="color:darkviolet">Redes do Participante</h2> 
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

    <form class="row g-3" method="GET" action="{{route('consulta_redes')}}">

          @csrf
     
          <div class="col-sm-8">
               <input class="form-control texto_p" id="consulta"  name="consulta" value="{{Session::get('criterio')}}" type="search">
               <input name="id_part" type="hidden" value="{{$part->id}}"> 
          </div>
      
        <div class="col-sm">
          <button style="margin-right: 20px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
          <!--<a class="btn btn btn-redes bi-snow" type="button"> Incluir Rede</a> -->
          
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-redes btn-sm bi-snow" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Incluir Rede
          </button>
          <button type="button" class="btn btn-criar-redes btn-sm bi-snow" data-bs-toggle="modal" data-bs-target="#staticBackdropNovaRede">
            Criar Nova Rede
          </button>
        </div>
        
    </form>
    
    <form action="{{route('incluir_redes_part')}}" method="post">

      @csrf
      
          <!-- Modal Incluir Rede-->
          <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Incluir Rede para: {{$part->nome_part}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                      <div class="modal-body">
                        <div class="mb-3">

                          <input value="{{$part->id}}" name="id_part" type="hidden">
                          
                          <label for="exampleFormControlInput1" class="form-label">Selecione uma Rede</label>
                          <select type="text" name="id_rede" id="exampleFormControlInput1" class="form-select" aria-label="Default select example" required>
                            <option value = ""></option>
                            @foreach ($redes as $rede)
                              <option value="{{ $rede->id }}"> 
                                    {{ $rede->nome }} 
                              </option>
                            @endforeach
                          </select>
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


    <form action="{{route('nova_rede')}}" method="post">
      
      @csrf

    <!-- Modal Criar Nova Rede -->
    <div class="modal fade" id="staticBackdropNovaRede" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Criar Nova Rede</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
          <div class="modal-body">
               <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nome</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="nome" required>
              </div>
              <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Descrição</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="descricao" required></textarea>
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

    @if (isset($rps)) 

    <table class="table table-sm texto_m">
        <thead>
          <tr>
            <th scope="col">Rede</th>
            <th scope="col">Descrição</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @if (count($rps)>0)

              @foreach($rps as $rp)
                <div>
                  <tr>
                    <td>{{$rp->nome}}</td>
                    <td>{{$rp->descricao}}</td>
                    
                    <td>
                      <button class="btn btn-danger btn-sm bi bi-trash" type="button" data-bs-toggle="modal" data-bs-target="#ModalExcluiRede-{{$rp->id}}" >Excluir</button>

                      <form class="" action="/deleta_rede_part/{{$rp->id}}" method="POST">
                          @csrf
                          @method('DELETE')
                      
                          <!-- Modal -->
                          <div class="modal fade" id="ModalExcluiRede-{{$rp->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Confirma Exclusão da Rede "{{$rp->nome}}" para {{$part->nome_part}} ?</h5>
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
           {{$rps->links('layouts.paginationlinks')}}
           
      </div>

    @endif 
  </div>

@endsection


