@extends('layout.site')

@section('titulo', 'Página Inicial')

@section('conteudo')

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Vendedor</h5>
            <p class="card-text">Controle dos Vendedores da rede binária.</p>
            <button id="adicionar" class="btn btn-primary" type="submit" name="button">Adicionar Vendedor</button>
          </div>
        </div>
      </div>
      </div>
      <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Gerar Relatório</h5>
            <p class="card-text">Gerar Relatórios da rede binária.</p>
            <form class="" action="{{route('rede.buscarRelatorio')}}" method="post">
              {{ csrf_field() }}
              <div class="form-group row" >
                <label for="id" class="col-md-6 col-form-label">Digite o ID do Vendedor:
                  <hr class="mt">
                </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="id">
                </div>
              </div>
              <button class="btn btn-primary" type="submit" name="button">Relatório Vendedor</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-muted">
      Maycon da Silva Moreira - 28/05/2019
    </div>
  </div>
</div>
@endsection
