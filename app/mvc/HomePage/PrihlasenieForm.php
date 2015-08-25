<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

/*
 * Tovarna na prihlasovacie formy
 */
class PrihlasenieForm extends Nette\Object
{
	private $databaza;
	private $presenter;

	public function __construct(Nette\Database\Context $databaza, $presenter)
	{
		$this->databaza = $databaza;
		$this->presenter = $presenter;
	}

	/*
	 * Vytvori form na prihlasenie
	 */
	public function vytvorit()
	{
		$form = new Form;
		$form->addText('RodneCislo', 'Rodné číslo:')->setRequired();
		$form->addPassword('heslo', 'Heslo:')->setRequired();
		$form->addSubmit('prihlasit', 'Prihlásiť');

		$form->onSuccess[] = array($this, 'prihlasenie');
		return $form;
	}

	/*
	 * Prihlasenie uzivatela po odoslani formularu
	 */
	public function prihlasenie(Form $form, $values)
	{
		$uzivatel = $this->presenter->getUser();
		$uzivatel->login($values->RodneCislo, $values->heslo);
		$this->presenter->redirect('Uzivatelia:default');
	}
}
