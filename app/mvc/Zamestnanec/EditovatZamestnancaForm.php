<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Test\Bs3FormRenderer;

/*
 * Tovarna na formy editovat zamestnanca
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class EditovatZamestnancaForm extends Nette\Object
{
	private $database;
	public $RodneCislo;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	public function vytvorit()
	{
		$form = new Form;
		$form->addText('RodneCislo', '*Rodné Číslo:')->setRequired()->addRule(Form::INTEGER, 'Rodné číslo môže obsahovať iba číslice!');
		$form->addText('meno', '*Meno:')->setRequired();
		$form->addText('priezvisko', '*Priezvisko:')->setRequired();
		$form->addText('titul', 'Titul:');
		$form->addText('datumNarodenia', "Dátum narodenia(YYYY-MM-DD):")->addCondition(Form::FILLED)->addRule(Form::PATTERN, 'Nesprávny fomrát', '([0-9]){4}-([0-9]){1,2}-([0-9]){1,2}');;
		$form->addText('adresa', 'Adresa:');
		$form->addText('IBAN', 'IBAN:');
		$form->addSelect('funkcia', '*Funkcia:', array('riaditeľ' => 'Riaditeľ', 'zamestnanec' => 'Zamestnanec'))->setRequired();
		$form->addSubmit('editovat', 'Editovať');
		$form->onSuccess[] = array($this, 'uspesne');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	public function uspesne(Form $form, $hodnoty)
	{
		foreach ($hodnoty as &$hodnota) if ($hodnota === '') $hodnota = NULL; // zmenim prazdne stringy na nully, kvoli db
		$zaznam = $this->database->table('zamestnanec')->get($this->RodneCislo);
		$zaznam->update($hodnoty);
		$form->getPresenter()->redirect('Zamestnanec:viac', $this->RodneCislo);
	}

}
