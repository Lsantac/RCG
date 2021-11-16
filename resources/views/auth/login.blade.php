
@extends('master')

@section('content')

<div class="container">
    <br><br><br><br>
    <div class="row justify-content-center">
         <div class="col-4">
   
            <form action="{{route('auth.login')}}" method="post">
  
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

                    @if(Session::get('podealterar'))
                        <div class="alert alert-danger">
                            {{Session::get('podealterar')}}
                        </div>
                    @endif
                    
                </div>
                
                <h4>Entre com suas credenciais :</h4>
                <hr>

                <div class="form-group">
                    @csrf
                <label for="email">Email</label>
                <input type="email" name="email"  class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email">
                @error('email')
                    <div class="invalid-feedback">
                         {{$message}}
                    </div>      
                @enderror

                </div>
                <br>
                <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" class="form-control @error('senha') is-invalid @enderror" id="senha" placeholder="">
                @error('senha')
                    <div class="invalid-feedback">
                         {{$message}}
                    </div>      
                @enderror
                </div>
                <br>               
                <button type="submit" class="btn btn-primary">Entrar</button>
                <a class="btn btn-success" href="novo_participante" role="button">Novo Participante</a>
                
            
            </form>
            
            <hr>
         </div>
    </div>
</div>


@endsection