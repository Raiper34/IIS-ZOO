<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Test\Bs3FormRenderer;


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
		$form->addText('meno', '*Meno:')->setRequired();
		$form->addText('datumNarodenia', 'Dátum narodenia(YYYY-MM-DD):')->addCondition(Form::FILLED)->addRule(Form::PATTERN, 'Nesprávny fomrát', '([0-9]){4}-([0-9]){1,2}-([0-9]){1,2}');
		$form->addText('datumUmrtia', 'Dátum úmrtia(YYYY-MM-DD):')->addCondition(Form::FILLED)->addRule(Form::PATTERN, 'Nesprávny fomrát', '([0-9]){4}-([0-9]){1,2}-([0-9]){1,2}');
		$form->addText('trieda', 'Trieda:');
		$form->addText('rad', 'Rad:');
		$form->addText('celad', 'Čelaď:');
		$form->addText('rod', 'Rod:');

		//Druh zivocicha
		$hodnotyDruhu = array();
		$druhyZivocichov = $this->database->table('druhZivocicha');
		foreach($druhyZivocichov as $druhZivocicha)
		{
			$hodnotyDruhu[$druhZivocicha->IDDruhuZivocicha] = $druhZivocicha->nazov;
		}
		$form->addSelect('IDDruhuZivocicha', '*Druh:', $hodnotyDruhu)->setRequired();

		//Umiestnenia
		$hodnotyUmiestnenia = array();
		$umiestnenia = $this->database->table('umiestnenie');
		foreach($umiestnenia as $umiestnenie)
		{
			$hodnotyUmiestnenia[$umiestnenie->IDUmiestnenia] = $umiestnenie->nazov;
		}
		$form->addSelect('IDUmiestnenia', '*Umiestnenie:', $hodnotyUmiestnenia)->setRequired();

		$form->addSubmit('vytvorit', 'Vytvoriť');

		$form->onSuccess[] = array($this, 'uspesne');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	/*
	 * Po uspesnom vytvoreni formulara sa uzivatel vytvori
	 */ 
	public function uspesne(Form $form, $hodnoty)
	{
		$this->database->table('zivocich')->insert($hodnoty);
		$form->getPresenter()->redirect('Zivocich:vypis');
	}

}
