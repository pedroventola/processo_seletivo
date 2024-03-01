<?php

class Arredondamento extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'arredondamentos';

    protected $fillable = array('id', 'nome');


	public static function arredondaNota($nota_final) {

		$fracao = $nota_final - floor($nota_final);

		if($fracao >= 0.7){
			$nota_final = ceil($nota_final); //arredondando para o numero mais proximo
		} else {
			$nota_final = floor($nota_final); //arredonda para baixo

		}

		return $nota_final;
	} 
}