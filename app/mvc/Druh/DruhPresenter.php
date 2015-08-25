<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\ViacButton;
use App\Forms\VytvoritDruhForm;
use App\Forms\EditovatDruhForm;

/*
 * Stranky s druhmi zvierat a prislusnych akciami
 */
class DruhPresenter extends BasePresenter
{
	private $database;
	public $Id;
	private $tovarna;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	public function actionDefault()
	{
		$this->redirect('Druh:vypis');
	}

	/******************* Vypis ***********************/
	public function renderVypis()
	{
		$this->template->druhy = $this->database->table('druhZivocicha');
	}

	protected function createComponentVytvoritForm()
	{
		$form = (new VytvoritDruhForm($this->database))->vytvorit();
		return $form;
	}

	protected function createComponentViacButton()
	{
		return new Multiplier(function ($Id)
		{
			$form = (new ViacButton($this->database, $Id, 'Druh:viac'))->vytvorit();
			return $form;
		});
	}

	/******************* Viac ************************/
	public function renderViac($Id)
	{
		$this->template->druh = $this->database->table('druhZivocicha')->get($Id);
	}

	public function actionViac($Id)
	{
		$this->Id = $Id;
	}
	protected function createComponentEditovatButton()
	{
		$form = new Form;
		$form->addSubmit('editovat', 'Editovať');

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
		$form->addSubmit('vymazat', 'Vymazať');

		$form->onSuccess[] = array($this, 'uspesneVymazatButton');
		return $form;
	}

	public function uspesneVymazatButton(Form $form, $hodnoty)
	{
		$this->database->table('druhZivocicha')->where('IDDruhuZivocicha', $this->Id)->delete();
		$form->getPresenter()->redirect('Druh:vypis');
	}

	/***************** Eitovat ***********************/
	public function actionEditovat($Id)
	{
		$this->Id = $Id;
		$zaznam = $this->database->table('druhZivocicha')->get($Id);
		$zaznam = $zaznam->toArray();

		$this["editovatForm"]->setDefaults($zaznam);
		$this->tovarna->Id = $Id;
	}

	protected function createComponentEditovatForm()
	{
		$this->tovarna = (new EditovatDruhForm($this->database));
		$form = $this->tovarna->vytvorit();
		return $form;
	}
}
