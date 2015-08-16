<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


class VymazatUzivatelaForm extends Nette\Object
{
	private $database;
	private $presenter;
	private $id;

	public function __construct(Nette\Database\Context $databaza, $presenter, $id)
	{
		$this->database = $databaza;
		$this->presenter = $presenter;
		$this->id = $id;
	}

	public function create()
	{
		$form = new Form;
		$form->addSubmit('odstranit', 'Odstranit');

		$form->onSuccess[] = array($this, 'formSucceeded');
		return $form;
	}


	public function formSucceeded(Form $form, $values)
	{
		$this->database->table('pouzivatelia')->where('id', $this->id)->delete();
		$this->presenter->redirect('Homepage:default');
	}

}
