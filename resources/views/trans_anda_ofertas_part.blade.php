@extends('master')

@section('content')


<div class="container-fluid">

    <h2 class="texto-oferta">Ofertas em andamento do Participante</h2> 
    <h5 class="texto-nome-logado">{{Session::get('nomelogado')}}</h5> 
    <br>

    </div>

    <form class="row g-3" method="get" action="">

          @csrf
     
          <div class="col-sm-8">
               <input class="form-control texto_m" name="consulta_of_part" value="" placeholder="Digite palavras para consulta..." type="search">
               <input name="id_part" type="hidden" value="{{$part->id}}"> 
          </div>
      
        <div class="col-sm">
          <button style="margin-right: 20px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
          
        </div>
        
    </form>

    <br>

    @if (isset($ofps)) 

    <table  class="table table-sm">
        <thead style="border-bottom: 1px solid black;">
          <tr>
            
            @if(Session::get('id_logado') == $part->id)  
                <th scope="col" class="texto_p" >Ações</th>
            @endif
            
          </tr>
        </thead>

        <tbody>
          @if (count($ofps)>0)

              @foreach($ofps as $ofp)


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

@endsection

