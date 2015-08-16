<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


class EditovatUzivatelaForm extends Nette\Object
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
		$form->addSubmit('editovat', 'Editovat');

		$form->onSuccess[] = array($this, 'formSucceeded');
		return $form;
	}

	public function createee()
	{
		$form = new Form;
		$form->addText('meno', 'Meno:');
		$form->addPassword('heslo', 'Heslo:');
		$form->addSelect('opravnenie', 'Opravnenie:', array('pracovnik' => 'Pracovnik', 'admin' => 'Admin'));
		$form->addSubmit('editovat', 'Eitovat');

		$zaznam = $this->database->table('pouzivatelia')->get($this->id);

		//$form->setDefaults(array('meno' => 'aaa', 'opravnenie' => 'admin'));
		$form->setDefaults($zaznam->toArray());

		$form->onSuccess[] = array($this, 'formSucceededdd');
		return $form;
	}


	public function formSucceeded(Form $form, $values)
	{
		$this->presenter->redirect('Editovanie:default', $this->id);
	}

	public function formSucceededdd(Form $form, $values)
	{
		/*$zaznam = $this->database->table('pouzivatelia')->get($this->id);
		$zmena = array('meno' => $values->meno, 'opravnenie' => $values->opravnenie);
		$zaznam->update($zmena);
		$this->presenter->redirect('Homepage:default');*/
	}

}
