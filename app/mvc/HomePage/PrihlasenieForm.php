<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Test\Bs3FormRenderer;

/*
 * Tovarna prihlasenie form
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class PrihlasenieForm extends Nette\Object
{
	private $databaza;

	/*
	 * Konstruktor triedy
	 */
	public function __construct(Nette\Database\Context $databaza)
	{
		$this->databaza = $databaza;
	}

	/*
	 * Vytvori form
	 * Vracia: vytvoreny form
	 */
	public function vytvorit()
	{
		$form = new Form;
		$form->addText('RodneCislo', 'Rodné číslo*:')->setRequired();
		$form->addPassword('heslo', 'Heslo*:')->setRequired();
		$form->addSubmit('prihlasit', 'Prihlásiť');

		$form->onSuccess[] = array($this, 'uspesne');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	/*
	 * Udalost po uspesnom odoslani formu
	 * form: samotny form
	 * hodnoty: hondoty formu
	 */
	public function uspesne(Form $form, $hodnoty)
	{
		$uzivatel = $form->getPresenter()->getUser();
		try
		{
			$uzivatel->login($hodnoty->RodneCislo, $hodnoty->heslo);
			$uzivatel->setExpiration('1 hour', FALSE);
			$form->getPresenter()->redirect('Umiestnenie:vypis');
		}
		catch(Nette\Security\AuthenticationException $chyba)
		{
			$form->getPresenter()->redirect('Homepage:prihlasenieNeuspech');
		}
	}
}