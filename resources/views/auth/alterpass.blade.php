
@extends('master')

@section('content')

<div class="container">
    <br><br><br><br>
    <div class="row justify-content-center">
         <div class="col-4">
   
            <form action="{{route('auth.alterpassok')}}" method="post">
  
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
                
                <h4>Alteração de Senha :</h4>
                <hr>

                <div class="form-group">
                    @csrf
                <label for="email">Email</label>
                <input disabled type="email" name="email" value="{{Session::get('email')}}" class="form-control" id="email">
                
                </div>
                <br>
                <div class="form-group">
                    <label for="senha">Senha atual</label>
                    <input type="password" name="senha" class="form-control @error('senha') is-invalid @enderror" id="senha" placeholder="">
                    @error('senha')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>      
                    @enderror
                    <br>
                    <label for="senha">Nova Senha</label>
                    <input type="password" name="novasenha" class="form-control @error('novasenha') is-invalid @enderror" id="novasenha" placeholder="">
                    @error('novasenha')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>      
                    @enderror
                </div>
                <br>               
                <button type="submit" class="btn btn-primary">Confirmar</button>
                
            </form>
            <hr>
         </div>
    </div>
</div>


@endsection