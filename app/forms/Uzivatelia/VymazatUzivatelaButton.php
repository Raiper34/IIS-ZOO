<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

/*
 * Tlacitko po ktorom kliknuti sa vymaze dany uzivatel, tovarenska classa
 */
class VymazatUzivatelaButton extends Nette\Object
{
	private $database;
	private $RodneCislo; //RodneCislo uzivatela na vymazanie

	public function __construct(Nette\Database\Context $databaza, $RodneCislo)
	{
		$this->database = $databaza;
		$this->RodneCislo = $RodneCislo;
	}

	/*
	 * Vytvorí tlacidlo a vrati ho
	 */
	public function vytvorit()
	{
		$form = new Form;
		$form->addSubmit('odstranit', 'Odstrániť');

		$form->onSuccess[] = array($this, 'uspesne');
		return $form;
	}

	/*
	 * Po kliknuti na tlacidlo sa odstrani dani uzivatel
	 */
	public function uspesne(Form $form, $hodnoty)
	{
		$this->database->table('zamestnanec')->where('RodneCislo', $this->RodneCislo)->delete();
		$form->getPresenter()->redirect('Uzivatelia:vypis');
	}

}
