<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

/*
 * Tovarenska metoda na tlacidla na editovanie uzivatela
 */
class EditovatUzivatelaButton extends Nette\Object
{
	private $database;
	public $RodneCislo;

	public function __construct(Nette\Database\Context $databaza, $RodneCislo)
	{
		$this->database = $databaza;
		$this->RodneCislo = $RodneCislo;
	}

	/*
	 * Vytvori tlacitko
	 */
	public function vytvorit()
	{
		$form = new Form;
		$form->addSubmit('editovat', 'Editovať');

		$form->onSuccess[] = array($this, 'uspesne');
		return $form;
	}

	/*
	 * Po kliknuti sa presmerujeme na editacnu stranku
	 */
	public function uspesne(Form $form, $values)
	{
		$form->getPresenter()->redirect('Uzivatelia:editovanie', $this->RodneCislo);
	}

}
