<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

/*
 * Tovarenska metoda formu na pridavanie uzivatelov
 */
class VytvoritZamestnancaForm extends Nette\Object
{
	private $database;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	/*
	 * Vytvori form a vrati ho
	 */
	public function vytvorit()
	{
		$form = new Form;
		$form->addText('RodneCislo', 'Rodné Číslo:')->setRequired()->addRule(Form::INTEGER, 'Rodné číslo môže obsahovať iba číslice!');
		$form->addText('meno', 'Meno:')->setRequired();
		$form->addText('priezvisko', 'Priezvisko:')->setRequired();
		$form->addText('titul', 'Titul:')->setRequired();
		$form->addText('datumNarodenia', "Dátum narodenia(YYYY-MM-DD):")->setRequired()->addRule(Form::PATTERN, 'Nesprávny fomrát', '([0-9]){4}-([0-9]){2}-([0-9]){2}');
		$form->addText('adresa', 'Adresa:')->setRequired();
		$form->addText('IBAN', 'IBAN:')->setRequired();
		$form->addPassword('heslo', 'Heslo:')->setRequired('');
		$form->addSelect('funkcia', 'Funkcia:', array('pracovnik' => 'Pracovnik', 'admin' => 'Admin'));
		$form->addSubmit('vytvorit', 'Vytvoriť');

		$form->onSuccess[] = array($this, 'uspesne');
		return $form;
	}

	/*
	 * Po uspesnom vytvoreni formulara sa uzivatel vytvori
	 */ 
	public function uspesne(Form $form, $hodnoty)
	{
		$hodnoty->datumNarodenia = $hodnoty->datumNarodenia + ' 00:00:00';
		$hodnoty->datumNarodenia = new \DateTime($hodnoty->datumNarodenia);
		$this->database->table('zamestnanec')->insert($hodnoty);
		$form->getPresenter()->redirect('Zamestnanec:vypis');
	}

}
