<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


class VytvoritDruhForm extends Nette\Object
{
	private $database;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	public function vytvorit()
	{
		$form = new Form;
		$form->addText('nazov', 'Názov:')->setRequired();
		$form->addSubmit('vytvorit', 'Vytvoriť');
		$form->onSuccess[] = array($this, 'uspesne');
		return $form;
	}
 
	public function uspesne(Form $form, $hodnoty)
	{
		$this->database->table('druhZivocicha')->insert($hodnoty);
		$form->getPresenter()->redirect('Druh:vypis');
	}

}
