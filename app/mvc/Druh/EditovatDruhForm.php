<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Test\Bs3FormRenderer;

class EditovatDruhForm extends Nette\Object
{
	private $database;
	public $Id;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	public function vytvorit()
	{
		$form = new Form;
		$form->addText('nazov', 'Názov:')->setRequired();
		$form->addSubmit('editovat', 'Editovať');
		$form->onSuccess[] = array($this, 'uspesne');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	public function uspesne(Form $form, $hodnoty)
	{
		$zaznam = $this->database->table('druhZivocicha')->get($this->Id);
		$zaznam->update($hodnoty);
		$form->getPresenter()->redirect('Druh:vypis');
	}

}
