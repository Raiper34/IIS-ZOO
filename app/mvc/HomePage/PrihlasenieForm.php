<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Test\Bs3FormRenderer;

/*
 * Tovarna na prihlasovacie formy
 */
class PrihlasenieForm extends Nette\Object
{
	private $databaza;
	private $presenter;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->databaza = $databaza;
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
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	/*
	 * Prihlasenie uzivatela po odoslani formularu
	 */
	public function prihlasenie(Form $form, $values)
	{
		$uzivatel = $form->getPresenter()->getUser();
		$uzivatel->login($values->RodneCislo, $values->heslo);
		$uzivatel->setExpiration('1 hour', FALSE);
		$form->getPresenter()->redirect('Zamestnanec:vypis');
	}
}