<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Forms\PrihlasenieForm;

/*
 * Presenter na prihlasenie, prihlasovaci form, odhlasenie...
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
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
		if($uzivatel->isLoggedIn()) //ak je uzivatel prihlaseny hned redirectujem
		{
			$this->redirect('Umiestnenie:vypis');
		}
	}

	protected function createComponentPrihlasenie()
	{
		$form = (new PrihlasenieForm($this->database));
		return $form->vytvorit();
	}

	public function actionOdhlasit()
	{
		$uzivatel = $this->getUser();
		if($uzivatel->isLoggedIn()) //ak je uzivatel prihlaseny, tak ho odhlasim
		{
			$uzivatel->logout();
		}
		$this->redirect('Homepage:prihlasenie');
	}
}