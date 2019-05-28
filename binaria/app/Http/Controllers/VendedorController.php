<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendedorController extends Controller
{


  /**
   * [Carrega a interface de adicionar sistema.]
   * @return [interface adicionar]
   */
  public function adicionar()
  {
    return view('sistema.adicionar');
  }


  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      //
  }

  /**
   * Método responsável por salvar as instâncias de Vendedor.
   *
   * @param Request $request
   */
  public function salvar(Request $request) {
      $vendedores = (array) $request -> all();
      $dataSet = [];

      $dataSet[] = [
          'nome' => $vendedores['nome'],
          'esquerdo' => $vendedores['esquerdo'],
          'direito' => $vendedores['direito']
      ];

      DB::table('vendedors')->insert($dataSet);
  }
}
