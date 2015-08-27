<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

/*
 * Tovarenska classa na vytvaranie editacnych formularov
 */
class EditovatZivocichaForm extends Nette\Object
{
	private $database;
	public $Id;

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
		$form->addText('meno', 'Meno:')->setRequired();
		$form->addText('datumNarodenia', 'Dátum narodenia(YYYY-MM-DD):')->setRequired()->addRule(Form::PATTERN, 'Nesprávny fomrát', '([0-9]){4}-([0-9]){1,2}-([0-9]){1,2}');
		$form->addText('datumUmrtia', 'Dátum úmrtia(YYYY-MM-DD):')->setRequired()->addRule(Form::PATTERN, 'Nesprávny fomrát', '([0-9]){4}-([0-9]){1,2}-([0-9]){1,2}');
		$form->addText('trieda', 'Trieda:')->setRequired();
		$form->addText('rad', 'Rad:')->setRequired();
		$form->addText('celad', 'Čelaď:')->setRequired();
		$form->addText('rod', 'Rod:')->setRequired();

		//Druh zivocicha
		$hodnotyDruhu = array();
		$druhyZivocichov = $this->database->table('druhZivocicha');
		foreach($druhyZivocichov as $druhZivocicha)
		{
			$hodnotyDruhu[$druhZivocicha->IDDruhuZivocicha] = $druhZivocicha->nazov;
		}
		$form->addSelect('IDDruhuZivocicha', 'Druh:', $hodnotyDruhu);

		//Umiestnenia
		$hodnotyUmiestnenia = array();
		$umiestnenia = $this->database->table('umiestnenie');
		foreach($umiestnenia as $umiestnenie)
		{
			$hodnotyUmiestnenia[$umiestnenie->IDUmiestnenia] = $umiestnenie->nazov;
		}
		$form->addSelect('IDUmiestnenia', 'Umiestnenie:', $hodnotyUmiestnenia);
		$form->addSubmit('editovat', 'Editovať');
		$form->onSuccess[] = array($this, 'uspesne');
		return $form;
	}

	/*
	 * Po odoslani formulara sa edituje uzivatel s novymi hodnotami
	 */
	public function uspesne(Form $form, $hodnoty)
	{
		$zaznam = $this->database->table('zivocich')->get($this->Id);
		$zaznam->update($hodnoty);
		$form->getPresenter()->redirect('Zivocich:vypis');
	}

}
