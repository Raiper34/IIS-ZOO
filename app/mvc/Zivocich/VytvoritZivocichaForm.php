<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


class VytvoritZivocichaForm extends Nette\Object
{
	private $database;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	public function vytvorit()
	{
		$form = new Form;
		$form->addText('meno', 'Meno:')->setRequired();
		$form->addText('datumNarodenia', 'Dátum narodenia(YYYY-MM-DD):')->setRequired()->addRule(Form::PATTERN, 'Nesprávny fomrát', '([0-9]){4}-([0-9]){2}-([0-9]){2}');;
		$form->addText('datumUmrtia', 'Dátum úmrtia(YYYY-MM-DD):')->setRequired()->addRule(Form::PATTERN, 'Nesprávny fomrát', '([0-9]){4}-([0-9]){2}-([0-9]){2}');;
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

		$hodnoty->datumUmrtia = $hodnoty->datumUmrtia + ' 00:00:00';
		$hodnoty->datumUmrtia = new \DateTime($hodnoty->datumUmrtia);

		$this->database->table('zivocich')->insert($hodnoty);
		$form->getPresenter()->redirect('Zivocich:vypis');
	}

}
