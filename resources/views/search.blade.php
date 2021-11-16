<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teste com consulta e paginação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
    <div class="container">
       <div class="row"> 
           <div class="col-md-6" style="margin-top: 40px">
               <h4>Procura tudo :</h4>
               <br>
               <form action="{{route('web.search')}}" method="GET">
                     <div class="form-group">
                          <label for="">Entre com palavra a procurar :</label>
                          <input type="text" class="form-control" name="query" placeholder="Procure aqui ...">
                     </div>
                     <br>
                     <div class="form-group">
                         <button type="submit" class="btn btn-primary">Procurar</button>
                     </div>
               </form>
            
               <br>
               <br>
               @if (isset($part)) 

               <table class="table table-sm">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Pais</th>
                    <th scope="col">Cep</th>
                    <th scope="col">Email</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  @if (count($part)>0)

                        @foreach($part as $p)
                            <div>
                            <tr>
                                <th scope="row">{{$p->id}}</th>
                                <td>{{$p->nome_part}}</td>
                                <td>{{$p->endereco}}</td>
                                <td>{{$p->cidade}}</td>
                                <td>{{$p->estado}}</td>
                                <td>{{$p->pais}}</td>
                                <td>{{$p->cep}}</td>
                                <td>{{$p->email}}</td>
                                <td>
                                <form class="" action="/participantes/{{$p->id}}" method="POST">
                                    <a href="/alterar_participantes/{{$p->id}}" class="btn btn-warning btn-sm"><i class="bi bi-pencil">Alterar</i></a>
                                    @csrf
                                    @method('DELETE')
                
                                    <button class="btn btn-danger btn-sm bi bi-trash" type="submit">Excluir</button>  
                                    </form>
                                </td>
                                
                            </tr>
                            </div> 
                            
                        @endforeach
                        
                  @else
                        <td><td>Nenhum resultado foi encontrado</td></td>
                  @endif 

                </tbody>
              </table>

              <div class="pagination">
                   {{$part->links('layouts.paginationlinks')}}
              </div>

              @endif 

           </div>
       </div>
    </div>

</body>
</html>