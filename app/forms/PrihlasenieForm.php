<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


class PrihlasenieForm extends Nette\Object
{
	private $database;
	private $presenter;

	public function __construct(Nette\Database\Context $databaza, $presenter)
	{
		$this->database = $databaza;
		$this->presenter = $presenter;
	}

	public function create()
	{
		$form = new Form;
		$form->addText('meno', 'Meno:')->setRequired('Prosim zadajte meno.');
		$form->addPassword('heslo', 'Heslo:')->setRequired('Prosim zadajte heslo.');
		$form->addSubmit('prihlasit', 'Prihlasit');

		$form->onSuccess[] = array($this, 'formSucceeded');
		return $form;
	}


	public function formSucceeded(Form $form, $values)
	{
		$user = $this->presenter->getUser();
		$user->login($values->meno, $values->heslo);
		$this->presenter->redirect('Homepage:default');
	}

}
