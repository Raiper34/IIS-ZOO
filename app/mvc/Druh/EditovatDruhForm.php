<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Test\Bs3FormRenderer;

/*
 * Tovarna Editacny form, na editaciu druhu zivocicha
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class EditovatDruhForm extends Nette\Object
{
	private $database;
	public $Id; //id druhu ktoreho cheme editovat

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
		$form->addSubmit('editovat', 'Editovať');
		$form->onSuccess[] = array($this, 'uspesne');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	/*
	 * Udalost po uspesnom odoslani formulara
	 * form: samotny form
	 * hodnoty: hondoty formu
	 */
	public function uspesne(Form $form, $hodnoty)
	{
		$zaznam = $this->database->table('druhZivocicha')->get($this->Id);
		$zaznam->update($hodnoty);
		$form->getPresenter()->flashMessage('Úspešne editované!', 'uspech');
		$form->getPresenter()->redirect('Druh:viac', $this->Id);
	}

}
