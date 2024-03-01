<?php

class Calculo extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'calculos';

    protected $fillable = array('id', 'nome');

	public static function calculaNotaFinal($nota_1bim, $nota_2bim, $nota_3bim, $nota_4bim) {
	
		$nota_final = ($nota_1bim + $nota_2bim + ($nota_3bim * 2) + ($nota_4bim * 2)) / 6; //formula do calculo da nota
	
		return $nota_final;
	}

}