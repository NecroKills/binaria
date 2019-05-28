<?php

namespace App\Http\Template;

class RedeTemplate
{

    protected $arrayEsquedo = array();
    protected $arrayDireito = array();

    /**
     * Método responsável por gerar o relatório em PDF.
     * @param $arvore
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function gerarPdf($arvore) {

        if(!is_null($arvore -> esquerdo)) {
            $this->gerarArrayEsquerdo($arvore->esquerdo);
        }

        $tempEsquerdo = $this->arrayEsquedo;
        $this->arrayEsquedo = array();

        if(!is_null($arvore -> direito)) {
            $this->gerarArrayDireito($arvore->direito);
        }

        $html = '
                    <h4>Pontuação de vendedores</h4>
                    <table style="border-collapse: collapse;" border="1">
                    <tr>
                        <th colspan="2">Pts perna esquerda do vendedor '.$arvore->vendedor.'</th>
                        <th colspan="2">Pts perna direita do vendedor '.$arvore->vendedor.'</th>
                    </tr>
                ';

        $arrayPontos = $this->mergeArrayPontos($tempEsquerdo, $this->arrayDireito);

        foreach ($arrayPontos as $linha) {
            $html .= '<tr>';
            $html .= "<td>{$linha->nomeEsquerdo}</td>";
            $html .= empty($linha->pontosEsquerdo) ? "<td></td>" : "<td>{$linha->pontosEsquerdo} pts</td>";
            $html .= "<td>{$linha->nomeDireito}</td>";
            $html .= empty($linha->pontosDireito) ? "<td></td>" : "<td>{$linha->pontosDireito} pts</td>";
            $html .= '</tr>';
        }

        $html .= '<tr>';
        $html .= "<td style='font-weight: bold;' align='right'>TOTAL:</td>";
        $html .= "<td>{$arvore->totalEsquerdo} pts</td>";
        $html .= "<td style='font-weight: bold;' align='right'>TOTAL:</td>";
        $html .= "<td>{$arvore->totalDireito} pts</td>";
        $html .= '</tr>';

        $html .= '</table>';

        $html .= '
                    <h4 style=" margin-top: 2em">Nível dos vendedores</h4>
                    <table style="border-collapse: collapse;" border="1">
                    <tr>
                        <th>Vendedor</th>
                        <th>Pontos Perna Menor</th>
                        <th>Nível</th>
                    </tr>
                ';

        $pontoRaiz = $this->menorValor($arvore->totalEsquerdo, $arvore->totalDireito);

        $html .= '<tr>';
        $html .= "<td>Vendedor {$arvore->vendedor}</td>";
        $html .= "<td>{$pontoRaiz}</td>";
        $html .= "<td>". $this->nivel($pontoRaiz)."</td>";
        $html .= '</tr>';

        foreach ($tempEsquerdo as $item) {
            $html .= '<tr>';
            $html .= "<td>{$item -> nome}</td>";
            $html .= "<td>{$item -> menorPonto}</td>";
            $html .= "<td>". $this->nivel($item -> menorPonto)."</td>";
            $html .= '</tr>';
        }

        foreach ($this->arrayDireito as $item) {
            $html .= '<tr>';
            $html .= "<td>{$item -> nome}</td>";
            $html .= "<td>{$item -> menorPonto}</td>";
            $html .= "<td>". $this->nivel($item -> menorPonto)."</td>";
            $html .= '</tr>';
        }

        $html .= '</table>';

        require_once __DIR__ . '/../../../vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output();
        return $html;
    }

    /**
     * Método responsável por gerar o array da perna esquerda.
     *
     * @param $arvore
     * @return array
     */
    public function gerarArrayEsquerdo($arvore) {
        $objeto = new \stdClass();

        $objeto->nome = "Vendedor ".$arvore->vendedor;
        $objeto->pontos = $arvore->totalEsquerdo;
        $objeto->menorPonto = $this->menorValor($arvore -> totalEsquerdo, $arvore -> totalDireito);

        array_push($this->arrayEsquedo, $objeto);

        if(!is_null($arvore -> direito)) {
            $tempDireito = $this->gerarArrayDireito($arvore->direito);

            foreach ($tempDireito as $temp) {
                array_push($this->arrayEsquedo, $temp);
            }
        }

        if(!is_null($arvore -> esquerdo)) {
            $this->gerarArrayEsquerdo($arvore->esquerdo);
        }
        return $this->arrayEsquedo;
    }

    /**
     * Método responsável por gerar o array da perna direita.
     *
     * @param $arvore
     * @return array
     */
    public function gerarArrayDireito($arvore) {
        $objeto = new \stdClass();

        $objeto->nome = "Vendedor ".$arvore->vendedor;
        $objeto->pontos = $arvore->totalDireito;
        $objeto->menorPonto = $this->menorValor($arvore -> totalEsquerdo, $arvore -> totalDireito);

        array_push($this->arrayDireito, $objeto);

        if(!is_null($arvore -> esquerdo)) {
            $tempEsquerdo = $this->gerarArrayEsquerdo($arvore->esquerdo);

            foreach ($tempEsquerdo as $temp) {
                array_push($this->arrayDireito, $temp);
            }
        }

        if(!is_null($arvore -> direito)) {
            $this->gerarArrayDireito($arvore->direito);
        }

        return $this->arrayDireito;
    }

    /**
     * Método responsável por realizar o merge dos arrays das pernas esquerda e direita.
     *
     * @param $esquerdo
     * @param $direito
     * @return array
     */
    public function mergeArrayPontos($esquerdo, $direito) {
        $tamanho = count($esquerdo) > count($direito) ? count($esquerdo) : count($direito);
        $result = array();

        for ($i = 0; $i < $tamanho; $i++) {
            $objeto = new \stdClass();

            $objeto->nomeEsquerdo = empty($esquerdo[$i]) ? '' : $esquerdo[$i]->nome;
            $objeto->pontosEsquerdo = empty($esquerdo[$i]) ? '' : $esquerdo[$i]->pontos;
            $objeto->nomeDireito = empty($direito[$i]) ? '' : $direito[$i]->nome;
            $objeto->pontosDireito = empty($direito[$i]) ? '' : $direito[$i]->pontos;

            array_push($result, $objeto);
        }

        return $result;
    }

    /**
     * Método responsável verificar qual é o menor dos valores informados.
     *
     * @param $val1
     * @param $val2
     * @return mixed
     */
    public function menorValor($val1, $val2) {
        if($val1 < $val2) {
            return $val1;
        }

        return $val2;
    }

    /**
     * Método responsável por definir o nivel do vendedor.
     *
     * @param $pontos
     * @return string
     */
    public function nivel($pontos) {
        if($pontos < 1) {
            return "Vendedor";
        } elseif ($pontos <= 500) {
            return "Bronze";
        } elseif ($pontos > 500 && $pontos <= 1000) {
            return "Prata";
        } elseif ($pontos > 1000 && $pontos <= 2000) {
            return "Ouro";
        } else {
            return "Diamante";
        }
    }
}
