<?php

namespace App\Services;

Class NotasFormatar {
    public function formataNotasPeriodos($notas, $criterio_avaliativo)
    {
        if (!empty($notas) && !empty($criterio_avaliativo)) {
            foreach ($notas as $nota) {
                $nota->valor_nota = $this->arredondaNota($nota->valor_nota, $criterio_avaliativo->arredondamento_id);
            }
        }

        return $notas;
    }

    public function calculaNotaFinal($notas, $disciplinas, $criterio_avaliativo)
    {
        if (!empty($notas) && !empty($disciplinas) && !empty($criterio_avaliativo)) {
            $array_notas = [];

            foreach ($disciplinas as $disciplina) {
                foreach ($notas as $nota) {
                    if ($nota->disciplina_id == $disciplina->disciplina_id) {
                        $array_notas[] = [
                            'valor_nota' => $nota->valor_nota,
                            'disciplina_id' => $nota->disciplina_id
                        ];
                    }
                }
            }

            return $this->{"calculo$criterio_avaliativo->calculo_id"}($array_notas, $criterio_avaliativo->arredondamento_id);
        }
    }

    function calculo1($array_notas, $arredondamento_id) {
        $array_notas_finais = [];
    
        foreach ($array_notas as $nota) {
            $disciplina_id = $nota['disciplina_id'];
    
            if (!isset($array_notas_finais[$disciplina_id])) {
                $array_notas_finais[$disciplina_id] = [
                    'disciplina_id' => $disciplina_id,
                    'soma' => 0,
                    'contagem' => 0
                ];
            }
    
            $array_notas_finais[$disciplina_id]['soma'] += $nota['valor_nota'];
            $array_notas_finais[$disciplina_id]['contagem']++;
        }
    
        foreach ($array_notas_finais as &$nota_final) {
            $nota_final['valor_nota'] = $this->arredondaNota($nota_final['soma'] / $nota_final['contagem'], $arredondamento_id);
        }
    
        return $array_notas_finais;
    }

    function calculo2($array_notas, $arredondamento_id) {
        $array_notas_finais = [];
    
        foreach ($array_notas as $nota) {
            $disciplina_id = $nota['disciplina_id'];
    
            if (!isset($array_notas_finais[$disciplina_id])) {
                $array_notas_finais[$disciplina_id] = [
                    'disciplina_id' => $disciplina_id,
                    'soma' => 0
                ];
            }
    
            $array_notas_finais[$disciplina_id]['soma'] += $nota['valor_nota'];
        }
    
        foreach ($array_notas_finais as &$nota_final) {
            $nota_final['valor_nota'] = $this->arredondaNota($nota_final['soma'], $arredondamento_id);
        }
    
        return $array_notas_finais;
    }

    protected function arredondaNota($nota, $arredondamento_id)
    {
        if (!is_null($arredondamento_id) && !is_null($nota)) {
            return $this->{"arredondamento$arredondamento_id"}($nota);
        }

        return $nota;
    }

    protected function arredondamento1($valor_nota)
    {
        $valor_nota_arredondada = ceil($valor_nota);
        
        return $valor_nota_arredondada;
    }

    protected function arredondamento2($valor_nota)
    {
        $valor_nota_arredondada = floor($valor_nota);
        
        return $valor_nota_arredondada;
    }
}