<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


class EditovatUzivatelaForm extends Nette\Object
{
	private $database;
	public $id;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	public function create($id)
	{
		$this->id = $id;
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

		$form->onSuccess[] = array($this, 'formSucceededdd');
		return $form;
	}


	public function formSucceeded(Form $form, $values)
	{
		$form->getPresenter()->redirect('Editovanie:default', $this->id);
	}

	public function formSucceededdd(Form $form, $values)
	{
		/*$zaznam = $this->database->table('pouzivatelia')->get($this->id);
		$zmena = array('meno' => $values->meno, 'opravnenie' => $values->opravnenie);
		$zaznam->update($zmena);*/
		$form->getPresenter()->redirect('Homepage:default');
	}

}
