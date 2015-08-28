<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Test\Bs3FormRenderer;

/*
 * Tovarenska classa na vytvaranie editacnych formularov
 */
class EditovatZamestnancaForm extends Nette\Object
{
	private $database;
	public $RodneCislo;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	/*
	 * Vytvori form na editovanie
	 */
	public function vytvorit()
	{
		$form = new Form;
		$form->addText('RodneCislo', 'Rodné Číslo:')->setRequired()->addRule(Form::INTEGER, 'Rodné číslo môže obsahovať iba číslice!');
		$form->addText('meno', 'Meno:')->setRequired();
		$form->addText('priezvisko', 'Priezvisko:')->setRequired();
		$form->addText('titul', 'Titul:')->setRequired();
		$form->addText('datumNarodenia', "Dátum narodenia(YYYY-MM-DD):")->setRequired()->addRule(Form::PATTERN, 'Nesprávny fomrát', '([0-9]){4}-([0-9]){1,2}-([0-9]){1,2}');;
		$form->addText('adresa', 'Adresa:')->setRequired();
		$form->addText('IBAN', 'IBAN:')->setRequired();
		$form->addSelect('funkcia', 'Funkcia:', array('pracovnik' => 'Pracovnik', 'admin' => 'Admin'));
		$form->addSubmit('editovat', 'Editovať');
		$form->onSuccess[] = array($this, 'uspesne');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	/*
	 * Po odoslani formulara sa edituje uzivatel s novymi hodnotami
	 */
	public function uspesne(Form $form, $hodnoty)
	{
		$zaznam = $this->database->table('zamestnanec')->get($this->RodneCislo);
		$zaznam->update($hodnoty);
		$form->getPresenter()->redirect('Zamestnanec:viac', $this->RodneCislo);
	}

}
