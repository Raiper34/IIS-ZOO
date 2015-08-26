<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

/*
 * Tovarenska metoda na tlacidla na viac informacii
 */
class ViacButton extends Nette\Object
{
	private $database;
	public $Id;
	public $stranka;

	public function __construct(Nette\Database\Context $databaza, $Id, $stranka)
	{
		$this->database = $databaza;
		$this->Id = $Id;
		$this->stranka = $stranka;
	}

	/*
	 * Vytvori tlacitko
	 */
	public function vytvorit()
	{
		$form = new Form;
		$form->addSubmit('viac', 'Viac');

		$form->onSuccess[] = array($this, 'uspesne');
		return $form;
	}

	/*
	 * Po kliknuti sa presmerujeme na stranku s viac info
	 */
	public function uspesne(Form $form, $hodnoty)
	{
		$form->getPresenter()->redirect($this->stranka, $this->Id);
	}

}
