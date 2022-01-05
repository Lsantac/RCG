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
               <input name="id_part" type="hidden" value=""> 
          </div>
      
        <div class="col-sm">
          <button style="margin-right: 20px" class="btn btn-sm btn-primary " type="submit">Procurar</button>
          
        </div>
        
    </form>

    <br>

    @if (isset($of_status)) 

    <table  class="table table-sm">
        <thead style="border-bottom: 1px solid black;">
          <tr>

             <th scope="col" class="texto_p" >Ofertas</th>
            
          </tr>
        </thead>

        <tbody>
          @if (count($of_status)>0)

              @foreach($of_status as $of_st)
                    <td>
                      <div class="card" style="width: 45rem;">

                        <div class="card-body">

                            <div class="row align-items-start">
                                <div class="col">
                                      <h5 style="font-size:15px;"   class="card-title texto-oferta">Oferta : {{$of_st->desc_of}}</h5>
                                      <h6 style="color:rgb(4, 97, 97)"  class="card-subtitle mb-2 texto_m">Categoria : {{$of_st->desc_cat_of}} </h6>
                                      <p class="card-text texto_m">Obs : {{$of_st->obs_of}}</p>
                                </div>
                                
                          
                              </div>

                        </div>
                      </div>
                    </td>

              @endforeach

          @else
              <td><td>Nenhum registro encontrado</td></td>    
              
          @endif 

        </tbody>
      </table>

      <div class="pagination">
           {{$of_status->links('layouts.paginationlinks')}}
           
      </div>

    @endif 

<div>

@endsection

