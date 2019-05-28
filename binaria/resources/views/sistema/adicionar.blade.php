@extends('layout.site')

@section('titulo','Cadastrar')

@section('conteudo')
  <div class="container">

    <form class="" action="{{route('vendedor.salvar')}}" method="post">
      <div class="panel-body">
        <!-- DADOS DO SISTEMA -->
        <fieldset class="scheduler-border">
          <legend class="scheduler-border">Dados do Vendedor</legend>
          {{ csrf_field() }}
          <!-- NOME -->
          <div class="form-group row" >
            <label for="nome" class="col-md-6 col-form-label">Nome
              <hr class="mt">
            </label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="nome" maxlength="100" size="100" value="{{old('nome')}}">
            </div>
          </div>

          <!-- PERNAESQUERDA -->
          <div class="form-group row" >
            <label for="esquerdo" class="col-md-6 col-form-label">Perna Esquerda
              <hr class="mt">
            </label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="esquerdo" maxlength="10" size="10" value="{{old('esquerdo')}}">
            </div>
          </div>

          <!-- PERNADIREITA -->
          <div class="form-group row" >
            <label for="direito" class="col-md-6 col-form-label">Perna Direita
              <hr class="mt">
            </label>
            <div class="col-sm-6">
              <input type="text" class="form-control" maxlength="100" size="100" name="direito" value="{{old('direito')}}">
            </div>
          </div>

        </fieldset>
      </div>

      <!-- Footer - Botões -->
      <div class="card-footer text-muted">
        <div class="panel-footer clearfix">
          <div class="row">
            <div class="col-md-2 primeiro">
              <button class="btn btn-primary" >Salvar <i class="fas fa-save "></i></button>

            </div>
        </form>
        <div class="col-md-10 ultimo">
          <button class="btn btn-primary" type="button" id="voltar">
            <i class="fas fa-arrow-left"></i> Voltar</button>
        </div>
          </div>
        </div>
      </div>



  <!-- CSS -->
  <style media="screen">
  /* troca a ordem das divs */
  .primeiro {
  order: 2;
  }
  .ultimo {
    order: 1;
  }
  /* fim trocar ordem das div */
  </style>


@endsection
