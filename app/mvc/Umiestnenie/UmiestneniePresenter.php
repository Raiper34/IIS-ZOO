<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\ViacButton;
use App\Forms\VytvoritUmiestnenieForm;
use App\Forms\EditovatUmiestnenieForm;
use Test\Bs3FormRenderer;

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

	/******************* Vypis volne *******************/

	public function renderVypisVolne()
	{
		//$this->template->umiestnenia = $this->database->table('umiestnenie');
		$this->template->umiestnenia = $this->database->query('SELECT * FROM umiestnenie U WHERE 0 = (SELECT COUNT(*) FROM zivocich Z WHERE U.IDUmiestnenia = Z.IDUmiestnenia)');
	}

	/******************* Viac ************************/
	public function renderViac($Id)
	{
		$this->template->umiestnenie = $this->database->table('umiestnenie')->get($Id);
		$this->template->zivocichy = $this->database->table('zivocich')->where('IDUmiestnenia', $Id);
		$this->template->klietka = $this->database->table('klietka')->get($Id);
		$this->template->vybeh = $this->database->table('vybeh')->get($Id);

		$this->template->zamestnanci = $this->database->query('SELECT * FROM spravuje NATURAL JOIN zamestnanec WHERE IDUmiestnenia = ' . $Id);
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
		if($this->database->table('zivocich')->where('IDUmiestnenia', $this->Id)->count() == 0)
		{
			$this->database->table('klietka')->where('IDUmiestnenia', $this->Id)->delete();
			$this->database->table('vybeh')->where('IDUmiestnenia', $this->Id)->delete();
			$this->database->table('spravuje')->where('IDUmiestnenia', $this->Id)->delete();
			$this->database->table('umiestnenie')->where('IDUmiestnenia', $this->Id)->delete();
			$form->getPresenter()->redirect('Umiestnenie:vypis');
		}
		else
		{
			$form->getPresenter()->flashMessage('Ak chcete odstrániť toto umiestnenie, najprv premiestnite všetky živočíchy z tohoto umiestnenia!');
		}
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

	protected function createComponentPridatSpravuje()
	{
		$form = new Form;

		$hodnoty = array();
		$prvky = $this->database->table('zamestnanec');
		foreach($prvky as $prvok)
		{
			$hodnoty[$prvok->RodneCislo] = $prvok->meno . ' ' . $prvok->priezvisko;
		}
		$form->addSelect('RodneCislo', 'Rodné číslo:', $hodnoty);

		$form->addSubmit('pridat', 'Pridať');

		$form->onSuccess[] = array($this, 'uspesneSpravuje');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	public function uspesneSpravuje(Form $form, $hodnoty)
	{
		$hodnoty->IDUmiestnenia = $this->Id;
		if($this->database->table('spravuje')->where('RodneCislo', $hodnoty->RodneCislo)->where('IDUmiestnenia', $this->Id)->count() == 0)
		{
			$this->database->table('spravuje')->insert($hodnoty);
		}
		$this->redirect('Umiestnenie:viac', $this->Id);
	}	

	protected function createComponentOdstranitSpravujeButton()
	{
		return new Multiplier(function ($RodneCislo)
		{
			$form = new Form;
			$form->addSubmit('odstranit', 'Odstrániť')->setAttribute('class', 'btn btn-danger');
			$form->addHidden('RodneCislo')->setValue($RodneCislo);;

			$form->onSuccess[] = array($this, 'uspesneOdstranitSpravuje');
			return $form;
		});
	}

	public function uspesneOdstranitSpravuje($form)
	{
		$this->database->table('spravuje')->where('IDUmiestnenia', $this->Id)->where('RodneCislo', $form['RodneCislo']->getValue())->delete();
	}
}
