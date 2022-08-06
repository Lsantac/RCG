@extends('master')

@section('content')

<div class="container-fluid">

    <h2 style="color:darkviolet">Redes</h2> 
    
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

    <form class="row g-3" method="GET" action="{{route('consultar_todas_redes')}}">

          @csrf
     
          <div class="col-sm-8">
               <input class="form-control texto_p" id="consulta"  name="consulta" value="{{Session::get('criterio')}}" placeholder="Digite palavras para consulta..." type="search">
               
          </div>
      
        <div class="col-sm">
          <button style="margin-right: 20px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
          
        </div>
        
    </form>

    <br>

    @if (isset($redes)) 

    <table class="table table-sm texto_m">
        <thead>
          <tr>
            <th scope="col">Rede</th>
            <th scope="col">Descrição</th>
            <th scope="col">Criada pelo Participante</th>
            <th scope="col">Data Criação</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @if (count($redes)>0)

              @foreach($redes as $r)
                <div>
                  <tr>
                    <td>{{$r->nome}}</td>
                    <td>{{$r->descricao}}</td>
                    <td>{{$r->nome_part}}</td>
                    <td>
                      @php
                         $date = new DateTime($r->data_inic);
                         echo $date->format('d-m-Y');
                      @endphp
                    </td>
                    
                    <td>
                      <button class="btn btn-danger btn-sm bi bi-trash" type="button" data-bs-toggle="modal" data-bs-target="#ModalExcluiRede-{{$r->id}}" >Excluir</button>

                      <form class="" action="/deleta_rede/{{$r->id}}" method="POST">
                          @csrf
                          @method('DELETE')
                      
                          <!-- Modal -->
                          <div class="modal fade" id="ModalExcluiRede-{{$r->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Confirma Exclusão da Rede "{{$r->nome}}"  ?</h5>
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
           {{$redes->links('layouts.paginationlinks')}}
           
      </div>

    @endif 
  </div>

@endsection


