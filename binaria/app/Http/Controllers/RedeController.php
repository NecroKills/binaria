<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Template\RedeTemplate;
use App\ValueObject\Arvore;
use App\Vendedor;

class RedeController extends Controller
{
    protected $valorEsquerdo = 0;
    protected $valorDireito = 0;


    /**
     * [index description]
     * [Carrega a interface do sistema gerenciador do plano de carreira dos vendedores.]
     * @return [interface principal]
     */
    public function index (){
      return view('index');
    }

    public function buscarRelatorio (Request $request){
      $request->all();
      $id = $request['id'];
      $this->criarArvore($id);
    }

    /**
     * Método responsável por criar a árvore binária conforme os registros do banco de dados.
     *
     * @param $id
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function criarArvore($id) {

        $vendedor = Vendedor::where('id', $id)->first();

        $arvore = new Arvore();

        $arvore -> vendedor = $vendedor['id'];

        if(!is_null($vendedor['esquerdo'])) {
            $arvore -> esquerdo = $this->buscaEsquerdo($vendedor['esquerdo']);
        }

        if(!is_null($vendedor['direito'])) {
            $arvore -> direito = $this->buscaDireito($vendedor['direito']);
        }

        if(!is_null($arvore -> esquerdo)) {
            $arvore -> totalEsquerdo = $this->somaEsquerdo($arvore -> esquerdo);
        }

        $this->valorEsquerdo = 0;

        if(!is_null($arvore -> direito)) {
            $arvore -> totalDireito = $this->somaDireito($arvore -> direito);
        }

        $redeTemplate = new RedeTemplate();

        return $redeTemplate->gerarPdf($arvore);
    }

    /**
     * Método responsável por criar a perna esquerda da árvore.
     *
     * @param $id
     * @return Arvore
     */
    public function buscaEsquerdo($id) {
        $vendedor = Vendedor::where('id', $id)->first();

        $arvore = new Arvore();

        $arvore -> vendedor = $id;

        if(!is_null($vendedor['esquerdo'])) {
            $arvore -> esquerdo = $this->buscaEsquerdo($vendedor['esquerdo']);
        }

        if(!is_null($vendedor['direito'])) {
            $arvore -> direito = $this->buscaDireito($vendedor['direito']);
        }

        return $arvore;
    }

    /**
     * Método responsável por criar a perna direita da árvore.
     *
     * @param $id
     * @return Arvore
     */
    public function buscaDireito($id) {
        $vendedor = Vendedor::where('id', $id)->first();

        $arvore = new Arvore();

        $arvore -> vendedor = $id;

        if(!is_null($vendedor['esquerdo'])) {
            $arvore -> esquerdo = $this->buscaEsquerdo($vendedor['esquerdo']);
        }

        if(!is_null($vendedor['direito'])) {
            $arvore -> direito = $this->buscaDireito($vendedor['direito']);
        }

        return $arvore;
    }

    /**
     * Método responsável por realizar a soma da perna esquerda da árvore.
     *
     * @param $arvore
     * @return int|mixed
     */
    protected function somaEsquerdo($arvore) {

        $this->valorEsquerdo += 500;
        $arvore -> totalEsquerdo = 500;

        if(!is_null($arvore -> esquerdo)) {
            $this->somaEsquerdo($arvore->esquerdo);
        }
        if(!is_null($arvore -> direito)) {
            $arvore -> totalDireito = 500;
            $this -> valorEsquerdo += $this->somaDireito($arvore -> direito);
        }

        return $this->valorEsquerdo;
    }

    /**
     * Método responsável por realizar a soma da perna direita da árvore.
     *
     * @param $arvore
     * @return int|mixed
     */
    protected function somaDireito($arvore) {

        $this -> valorDireito += 500;
        $arvore->totalDireito = 500;

        if(!is_null($arvore -> direito)){
            $this->somaDireito($arvore -> direito);
        }

        if(!is_null($arvore -> esquerdo)) {
            $arvore -> totalEsquerdo = 500;
            $this->valorDireito += $this->somaEsquerdo($arvore -> esquerdo);
        }

        return $this->valorDireito;
    }
}
