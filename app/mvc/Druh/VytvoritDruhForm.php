<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Test\Bs3FormRenderer;

/*
 * Tovarna Vytvorit form, na vytvaranie druhu zivocicha
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class VytvoritDruhForm extends Nette\Object
{
	private $database;

	/*
	 * Konstruktor triedy
	 */
	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	/*
	 * Vytvori form
	 * Vracia: vytvoreny form
	 */
	public function vytvorit()
	{
		$form = new Form;
		$form->addText('nazov', '*Názov:')->setRequired();
		$form->addSubmit('vytvorit', 'Vytvoriť');
		$form->onSuccess[] = array($this, 'uspesne');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}
 
 	/*
 	 * Udalost po uspensnom odoslani formu
 	 * form: samotny form
 	 * hodnoty: hodnoty formu
 	 */
	public function uspesne(Form $form, $hodnoty)
	{
		$this->database->table('druhZivocicha')->insert($hodnoty);
		$form->getPresenter()->redirect('Druh:vypis');
	}

}
