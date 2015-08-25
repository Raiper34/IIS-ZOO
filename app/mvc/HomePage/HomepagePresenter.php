<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Forms\PrihlasenieForm;

/*
 * Hlavna stranka, zobrazuje iba prihlasenie
 */
class HomepagePresenter extends BasePresenter
{
	private $database;

	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	public function renderDefault()
	{
		$uzivatel = $this->getUser();
		//$uzivatel->login('0', '0');
		if($uzivatel->isLoggedIn()) //ak je uzivatel prihlaseny hed redirectujem
		{
			$this->redirect('Uzivatelia:vypis');
		}
	}

	/*
	 * Vytvorenie prihlasovacieho formu
	 */
	protected function createComponentPrihlasenie()
	{
		$form = (new PrihlasenieForm($this->database, $this))->vytvorit();
		return $form;
	}
}
