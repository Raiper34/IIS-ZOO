<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\VytvoritZamestnancaForm;
use App\Forms\VymazatZamestnancaButton;
use App\Forms\ViacButton;
use App\Forms\OdstranitButton;
use App\Forms\EditovatZamestnancaForm;
use Test\Bs3FormRenderer;

/*
 * Stranky s uzivatelmi a prislusnych akciami
 */
class ZamestnanecPresenter extends BasePresenter
{
	private $database;
	private $tovarna;
	private $RodneCislo;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	public function actionDefault()
	{
		$this->redirect('Zamestnanec:vypis');
	}

	/************************************ Vypis ****************************************/
	/*
	 * Stranka s vypisom uzivatelov a formom na pridavanie uzivatelov
	 */
	public function renderVypis()
	{
		if(!$this->getUser()->isLoggedIn())
		{
			$this->redirect('Homepage:prihlasenie');
		}
		else if($this->getUser()->roles[0] != 'riaditeľ')
		{
			$this->redirect('Homepage:prava');
		}
		$this->template->zamestnanci = $this->database->table('zamestnanec');
	}

	/*
	 * Vytvorenie formu na vytvorenie uzaivatela
	 */
	protected function createComponentVytvoritForm()
	{
		$form = (new VytvoritZamestnancaForm($this->database, $this))->vytvorit();
		return $form;
	}

	/*
	 * Vytvorenie buttonu na eitovanie uzivatela
	 */
	protected function createComponentViacButton()
	{
		return new Multiplier(function ($RodneCislo)
		{
			$form = (new ViacButton($this->database, $RodneCislo, 'Zamestnanec:viac'))->vytvorit();
			return $form;
		});
	}

	/********************************** Viac **********************************/

	public function renderViac($RodneCislo)
	{
		if(!$this->getUser()->isLoggedIn())
		{
			$this->redirect('Homepage:prihlasenie');
		}
		else if($this->getUser()->roles[0] != 'riaditeľ')
		{
			if($this->getUser()->id != $RodneCislo)
			{
				$this->redirect('Homepage:prava');
			}
		}
		$this->template->zamestnanec = $this->database->table('zamestnanec')->get($RodneCislo);

		$this->template->testy = $this->database->query('SELECT * FROM testoval NATURAL JOIN zivocich WHERE RodneCislo = ' . $RodneCislo);

		$this->template->umiestnenia = $this->database->query('SELECT * FROM spravuje NATURAL JOIN umiestnenie WHERE RodneCislo = ' . $RodneCislo);

		$this->template->zivocichy = $this->database->query('SELECT * FROM staraSa NATURAL JOIN zivocich WHERE RodneCislo = ' . $RodneCislo);
	}

	public function actionViac($RodneCislo)
	{
		$this->RodneCislo = $RodneCislo;
		$zaznam = $this->database->table('zamestnanec')->get($RodneCislo);
		$zaznam = $zaznam->toArray();

		//Prevod datumu z databaze na korespondujuci datum pre uzivatela
		$datum = date_parse($zaznam['datumNarodenia']); //iba roky mesiace a dni
		$rok =  $datum['year'];
		$mesiac = $datum['month'];
		$den = $datum['day'];
		$zaznam['datumNarodenia'] = $rok . '-' . $mesiac . '-' . $den;

		$this["editovatForm"]->setDefaults($zaznam);
		$this->tovarna->RodneCislo = $RodneCislo;
	}

	protected function createComponentOdstranitStaraSaButton()
	{
		return new Multiplier(function ($id)
		{
			$form = new Form;
			$form->addSubmit('odstranit', 'Odstrániť')->setAttribute('class', 'btn btn-danger');
			$form->addHidden('id')->setValue($id);;

			$form->onSuccess[] = array($this, 'uspesneOdstranitStaraSa');
			return $form;
		});
	}

	public function uspesneOdstranitStaraSa($form)
	{
		$this->database->table('staraSa')->where('RodneCislo', $this->RodneCislo)->where('IDZivocicha', $form['id']->getValue())->delete();
	}

	protected function createComponentOdstranitSpravujeButton()
	{
		return new Multiplier(function ($id)
		{
			$form = new Form;
			$form->addSubmit('odstranit', 'Odstrániť')->setAttribute('class', 'btn btn-danger');
			$form->addHidden('id')->setValue($id);;

			$form->onSuccess[] = array($this, 'uspesneOdstranitSpravuje');
			return $form;
		});
	}

	public function uspesneOdstranitSpravuje($form)
	{
		$this->database->table('spravuje')->where('RodneCislo', $this->RodneCislo)->where('IDUmiestnenia', $form['id']->getValue())->delete();
	}

	protected function createComponentPridatStaraSa()
	{
		$form = new Form;

		$hodnoty = array();
		$prvky = $this->database->table('zivocich');
		foreach($prvky as $prvok)
		{
			$hodnoty[$prvok->IDZivocicha] = $prvok->meno;
		}
		$form->addSelect('IDZivocicha', 'Živočích:', $hodnoty);

		$form->addSubmit('pridat', 'Pridať');

		$form->onSuccess[] = array($this, 'uspesneStaraSa');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	public function uspesneStaraSa(Form $form, $hodnoty)
	{
		$hodnoty->RodneCislo = $this->RodneCislo;
		if($this->database->table('staraSa')->where('RodneCislo', $this->RodneCislo)->where('IDZivocicha', $hodnoty->IDZivocicha)->count() == 0)
		{
			$this->database->table('staraSa')->insert($hodnoty);
		}
		$this->redirect('Zamestnanec:viac', $this->RodneCislo);
	}

	protected function createComponentPridatSpravuje()
	{
		$form = new Form;

		$hodnoty = array();
		$prvky = $this->database->table('umiestnenie');
		foreach($prvky as $prvok)
		{
			$hodnoty[$prvok->IDUmiestnenia] = $prvok->nazov;
		}
		$form->addSelect('IDUmiestnenia', 'Umiestnenie:', $hodnoty);

		$form->addSubmit('pridat', 'Pridať');

		$form->onSuccess[] = array($this, 'uspesneSpravuje');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	public function uspesneSpravuje(Form $form, $hodnoty)
	{
		$hodnoty->RodneCislo = $this->RodneCislo;
		if($this->database->table('spravuje')->where('RodneCislo', $this->RodneCislo)->where('IDUmiestnenia', $hodnoty->IDUmiestnenia)->count() == 0)
		{
			$this->database->table('spravuje')->insert($hodnoty);
		}
		$this->redirect('Zamestnanec:viac', $this->RodneCislo);
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
		$this->database->table('testoval')->where('RodneCislo', $this->RodneCislo)->delete();
		$this->database->table('staraSa')->where('RodneCislo', $this->RodneCislo)->delete();
		$this->database->table('spravuje')->where('RodneCislo', $this->RodneCislo)->delete();
		$this->database->table('zamestnanec')->where('RodneCislo', $this->RodneCislo)->delete();
		$form->getPresenter()->redirect('Zamestnanec:vypis');
	}

	protected function createComponentEditovatForm()
	{
		$this->tovarna = new EditovatZamestnancaForm($this->database, $this->RodneCislo);
		$form = $this->tovarna->vytvorit();
		return $form;
	}

}
