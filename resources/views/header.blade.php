

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid ">
        <a class="navbar-brand" href="/"><img src="/img/{{App\Http\Controllers\IdentController::consulta_logo()}}" class="imagem-header rounded-circle"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a style="color:rgb(0, 50, 97); " class="nav-link active" aria-current="page" href="/inicio">Início</a>
                </li>
                <li class="nav-item">
                  <a style=" color:rgb(17, 88, 196);" class="nav-link" href="/participantes">Participantes</a>
                </li>
                <li class="nav-item">
                  <a style="color:rgb(18, 134, 43); " class="nav-link" href="/ofertas">Ofertas</a>
                </li>
                <li class="nav-item">
                  <a style="color:rgb(126, 49, 13); " class="nav-link" href="/necessidades">Necessidades</a>
                </li>
              
                <li class="nav-item">
                  <a class="nav-link" href="">Redes</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="">Projetos</a>
                </li> 
                <li class="nav-item">
                  <a class="nav-link" href="">Eventos</a>
                </li> 
              </ul>

          </div>

          <div>
           @if(Session::get('nomelogado'))
              <form class="d-flex" action="{{route('auth.logout')}}" method="POST">
                @csrf
                @method('DELETE')
              
                  <div class="" href="">Seja Bem-Vindo,&nbsp &nbsp</div><div class="texto-nome-logado">{{Session('nomelogado')}}&nbsp &nbsp &nbsp</div>
                  <a href="/alterar_participantes/{{Session('id_logado')}}" id="dropdownMenuButton1">

                    @if(Session::get('imagem_logado'))
                      <img src="/uploads/participantes/{{Session('imagem_logado')}}" class="imagem-header rounded-circle">
                    @else
                      <img src="/img/logo.jpg" class="imagem-header rounded-circle">
                    @endif 
          
                  </a>

                  <div class="dropdown">
                    <button class="btn btn-blueviolet dropdown-toggle btn-sm" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      Configurações
                    </button>
                    <ul class="dropdown-menu texto_m" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item" href="{{route('auth.alterpass')}}">Alterar Senha</a></li>

                      @if(Session::get('id_tipo_acesso_logado') == 1)
                        <li><a style="color: red;"  class="dropdown-item" href="{{route('auth.resetpass')}}">Resetar Senha</a></li>
                        <li><a class="dropdown-item" href="/unidades">Unidades</a></li>
                      @endif

                      @if(Session::get('id_logado') > 0)
                        <li><a class="dropdown-item" href="/alterar_participantes/{{Session('id_logado')}}">Alterar Perfil</a></li>
                        <!--<li><a class="dropdown-item" href="#">Mapas</a></li>-->
                        <!--<li><a class="dropdown-item" href="#">Configurar Redes</a></li>-->
                        <li><a class="dropdown-item" href="/categorias">Categorias</a></li>
                        <li><a class="dropdown-item" href="/moedas">Moedas</a></li>
                        <li><a class="dropdown-item" href="/consulta_saldos/{{Session('id_logado')}}">Consulta Saldos</a></li>
                        <li><a class="dropdown-item" href="/identidade">Identidade do Sistema</a></li>
                      @endif
                    </ul>
                  </div>
                  &nbsp&nbsp

                  <button class="btn btn-sair btn-sm" type="submit">Sair</button>  
              
              </form>

          @else
              <a style="margin-right:10px;" class="btn btn-success btn-sm" href="novo_participante" role="button">Novo Participante</a>
              <button class="btn btn-primary btn-sm" type="button"><a style="color:white; text-decoration:none;" href="/login">Login</a></button>  
              
              
          @endif

         </div>
      </div>
    </nav>

    

   



