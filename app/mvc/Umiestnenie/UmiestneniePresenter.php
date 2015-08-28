<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\ViacButton;
use App\Forms\VytvoritUmiestnenieForm;
use App\Forms\EditovatUmiestnenieForm;


class UmiestneniePresenter extends BasePresenter
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
		$this->redirect('Umiestnenie:vypis');
	}

	/******************* Vypis ***********************/
	public function renderVypis()
	{
		//$this->template->umiestnenia = $this->database->table('umiestnenie');
		$this->template->umiestnenia = $this->database->query('SELECT * FROM umiestnenie NATURAL JOIN klietka UNION SELECT * FROM umiestnenie NATURAL JOIN vybeh');
	}

	protected function createComponentViacButton()
	{
		return new Multiplier(function ($Id)
		{
			$form = (new ViacButton($this->database, $Id, 'Umiestnenie:viac'))->vytvorit();
			return $form;
		});
	}

	protected function createComponentPridatKlietkuButton()
	{
		$form = new Form;
		$form->addSubmit('pridatKlietku', 'Pridať umiestnenie typu klietka');

		$form->onSuccess[] = array($this, 'uspesnePridatKlietkuButton');
		return $form;
	}

	public function uspesnePridatKlietkuButton(Form $form, $hodnoty)
	{
		$this->redirect('Umiestnenie:pridat', 0);
	}

	protected function createComponentPridatVybehButton()
	{
		$form = new Form;
		$form->addSubmit('pridatVybeh', 'Pridať umiestnenie typu vybeh');

		$form->onSuccess[] = array($this, 'uspesnePridatVybehButton');
		return $form;
	}

	public function uspesnePridatVybehButton(Form $form, $hodnoty)
	{
		$this->redirect('Umiestnenie:pridat', 1);
	}

	protected function createComponentVytvoritKliektuForm()
	{
		$form = (new VytvoritUmiestnenieForm($this->database, 0))->vytvorit();
		return $form;
	}

	protected function createComponentVytvoritVybehForm()
	{
		$form = (new VytvoritUmiestnenieForm($this->database, 1))->vytvorit();
		return $form;
	}

	/******************* Viac ************************/
	public function renderViac($Id)
	{
		$this->template->umiestnenie = $this->database->table('umiestnenie')->get($Id);
		$this->template->klietka = $this->database->table('klietka')->get($Id);
		$this->template->vybeh = $this->database->table('vybeh')->get($Id);
	}

	public function actionViac($Id)
	{
		$this->Id = $Id;

		if($this->database->table('klietka')->get($this->Id))
		{
			$mod = 0;
		}
		else
		{
			$mod = 1;
		}

		$this->template->mod = $mod;
		$zaznam = $this->database->table('umiestnenie')->get($Id);
		$zaznam = $zaznam->toArray();

		if($mod == 0)
		{
			$this["editovatKlietkuForm"]->components['umiestnenie']->setDefaults($zaznam);
			$zaznam = $this->database->table('klietka')->get($Id);
			$zaznam = $zaznam->toArray();
			$this["editovatKlietkuForm"]->components['klietka']->setDefaults($zaznam);
		}
		else
		{
			$this["editovatVybehForm"]->components['umiestnenie']->setDefaults($zaznam);
			$zaznam = $this->database->table('vybeh')->get($Id);
			$zaznam = $zaznam->toArray();
			$this["editovatVybehForm"]->components['vybeh']->setDefaults($zaznam);
		}

		$this->tovarna->Id = $Id;
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
		$this->database->table('klietka')->where('IDUmiestnenia', $this->Id)->delete();
		$this->database->table('vybeh')->where('IDUmiestnenia', $this->Id)->delete();
		$this->database->table('umiestnenie')->where('IDUmiestnenia', $this->Id)->delete();
		$form->getPresenter()->redirect('Umiestnenie:vypis');
	}

	protected function createComponentEditovatKlietkuForm()
	{
		$this->tovarna = (new EditovatUmiestnenieForm($this->database, 0));
		$form = $this->tovarna->vytvorit();
		return $form;
	}

	protected function createComponentEditovatVybehForm()
	{
		$this->tovarna = (new EditovatUmiestnenieForm($this->database, 1));
		$form = $this->tovarna->vytvorit();
		return $form;
	}	
}
