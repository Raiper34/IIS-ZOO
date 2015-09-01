<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

/*
 * Tovarenska metoda na tlacidla viac, ktore iba redirectuju na danu stranku polozky s viac informaciami
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class ViacButton extends Nette\Object
{
	private $database;
	public $Id;
	public $stranka;

	public function __construct(Nette\Database\Context $databaza, $Id, $stranka)
	{
		$this->database = $databaza;
		$this->Id = $Id; //id polozky
		$this->stranka = $stranka; //druh/zivocich/zamestnanec....
	}

	public function vytvorit()
	{
		$form = new Form;
		$form->addSubmit('viac', 'Viac')->setAttribute('class', 'btn btn-warning');

		$form->onSuccess[] = array($this, 'uspesne');
		return $form;
	}

	public function uspesne(Form $form, $hodnoty)
	{
		$form->getPresenter()->redirect($this->stranka, $this->Id);
	}

}
