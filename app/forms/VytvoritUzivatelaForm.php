<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


class VytvoritUzivatelaForm extends Nette\Object
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
		$form->addSelect('opravnenie', 'Opravnenie:', array('pracovnik' => 'Pracovnik', 'admin' => 'Admin'));
		$form->addSubmit('vytvorit', 'Vytvorit');

		$form->onSuccess[] = array($this, 'formSucceeded');
		return $form;
	}


	public function formSucceeded(Form $form, $values)
	{
		$this->database->table('pouzivatelia')->insert(array('meno' => $values->meno, 'heslo' => $values->heslo, 'opravnenie' => $values->opravnenie,));
		$this->presenter->redirect('Homepage:default');
	}

}
