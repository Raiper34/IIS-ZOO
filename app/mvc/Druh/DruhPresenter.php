<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\ViacButton;
use App\Forms\VytvoritDruhForm;
use App\Forms\EditovatDruhForm;

/*
 * Presenter Druh zivocicha
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class DruhPresenter extends BasePresenter
{
	private $database;
	public $Id; //id druhu
	private $tovarna; //tovarna na formy aby som mohol predat parametre

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	public function actionDefault()
	{
		$this->redirect('Druh:vypis');
	}

	/******************* Vypis sablona ***********************/
	public function renderVypis()
	{
		if(!$this->getUser()->isLoggedIn()) //ak uzivatel neni prihlaseny tak ho presmerujem
		{
			$this->redirect('Homepage:prihlasenie');
		}
		$this->template->druhy = $this->database->table('druhZivocicha'); //naplnim sablnu
	}

	protected function createComponentVytvoritForm()
	{
		$form = (new VytvoritDruhForm($this->database));
		return $form->vytvorit();
	}

	protected function createComponentViacButton()
	{
		return new Multiplier(function ($Id)
		{
			$form = (new ViacButton($this->database, $Id, 'Druh:viac'));
			return $form->vytvorit();
		});
	}

	/******************* Viac sablona ************************/
	public function renderViac($Id)
	{
		if(!$this->getUser()->isLoggedIn()) //ak uzivatel neni prihlaseny tak presmerujem
		{
			$this->redirect('Homepage:prihlasenie');
		}
		//naplnim sablonu
		$this->template->druh = $this->database->table('druhZivocicha')->get($Id);
		$this->template->zivocichy = $this->database->table('zivocich')->where('IDDruhuZivocicha', $Id);
	}

	public function actionViac($Id)
	{
		$this->Id = $Id;
		$zaznam = $this->database->table('druhZivocicha')->get($Id); //vytiahnem si z db data ktore pouzijem na default hodnoty
		$zaznam = $zaznam->toArray();

		$this["editovatForm"]->setDefaults($zaznam); //naplnim editacny form datami z databaze
		$this->tovarna->Id = $Id;
	}
	protected function createComponentEditovatButton()
	{
		$form = new Form;
		$form->addSubmit('editovat', 'Editovať')->setAttribute('class', 'btn btn-success');

		$form->onSuccess[] = array($this, 'uspesneEditovatButton');
		return $form;
	}

	public function uspesneEditovatButton(Form $form, $hodnoty)
	{
		$this->redirect('Druh:editovat', $this->Id);
	}

	protected function createComponentVymazatButton()
	{
		$form = new Form;
		$form->addSubmit('vymazat', 'Vymazať')->setAttribute('class', 'btn btn-danger');

		$form->onSuccess[] = array($this, 'uspesneVymazatButton');
		return $form;
	}

	public function uspesneVymazatButton(Form $form, $hodnoty)
	{
		if($this->database->table('zivocich')->where('IDDruhuZivocicha', $this->Id)->count() == 0) //mozem mazat iba ak neexistuje zivocich priradeny k tomuto druhu
		{
			$this->database->table('druhZivocicha')->where('IDDruhuZivocicha', $this->Id)->delete();
			$form->getPresenter()->redirect('Druh:vypis');
		}
		else //existuje taky zivocich tak iba ukazem hlasku
		{
			$form->getPresenter()->flashMessage('Ak chcete vymazať tento druh živočícha, zmente druhy živočíchom, ktorý majú nastavený tento druh!');
		}
	}

	protected function createComponentEditovatForm()
	{
		$this->tovarna = (new EditovatDruhForm($this->database));
		$form = $this->tovarna->vytvorit();
		return $form;
	}
}
