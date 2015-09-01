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
		$this->redirect('Homepage:prihlasenie');
	}

	public function renderPrihlasenie()
	{
		$uzivatel = $this->getUser();
		if($uzivatel->isLoggedIn()) //ak je uzivatel prihlaseny hed redirectujem
		{
			$this->redirect('Umiestnenie:vypis');
		}
	}

	/*
	 * Vytvorenie prihlasovacieho formu
	 */
	protected function createComponentPrihlasenie()
	{
		$form = (new PrihlasenieForm($this->database))->vytvorit();
		return $form;
	}

	public function actionOdhlasit()
	{
		$uzivatel = $this->getUser();
		if($uzivatel->isLoggedIn())
		{
			$uzivatel->logout();
		}
		$this->redirect('Homepage:prihlasenie');
	}
}