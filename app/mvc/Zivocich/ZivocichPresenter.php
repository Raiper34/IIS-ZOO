<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\VytvoritZivocichaForm;
use App\Forms\ViacButton;
use App\Forms\EditovatZivocichaForm;
use Test\Bs3FormRenderer;

/*
 * Stranky s uzivatelmi a prislusnych akciami
 */
class ZivocichPresenter extends BasePresenter
{
	private $database;
	private $tovarna;
	private $Id;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	public function actionDefault()
	{
		$this->redirect('Zamestnanec:vypis');
	}

	/************************************ Vypis ****************************************/
	public function renderVypis()
	{
		if(!$this->getUser()->isLoggedIn()) //uzivatel neni prihlaseny
		{
			$this->redirect('Homepage:prihlasenie');
		}
		$this->template->zivocichi = $this->database->table('zivocich');
	}

	protected function createComponentVytvoritForm()
	{
		$form = (new VytvoritZivocichaForm($this->database, $this));
		return $form->vytvorit();
	}

	protected function createComponentViacButton()
	{
		return new Multiplier(function ($Id)
		{
			$form = (new ViacButton($this->database, $Id, 'Zivocich:viac'));
			return $form->vytvorit();
		});
	}

	/********************************** Viac **********************************/

	public function renderViac($Id)
	{
		if(!$this->getUser()->isLoggedIn()) //uzivatel neni prihlaseny
		{
			$this->redirect('Homepage:prihlasenie');
		}
		$this->template->zivocich = $this->database->table('zivocich')->get($Id);
		$this->template->druh = $this->database->table('druhZivocicha')->get($this->template->zivocich->IDDruhuZivocicha);
		$this->template->umiestnenie = $this->database->table('umiestnenie')->get($this->template->zivocich->IDUmiestnenia);

		$this->template->testy = $this->database->query('SELECT * FROM testoval NATURAL JOIN zamestnanec WHERE IDZivocicha = ' . $Id);
		$this->template->zamestnanci = $this->database->query('SELECT * FROM staraSa NATURAL JOIN zamestnanec WHERE IDZivocicha = ' . $Id);
	}

	public function actionViac($Id)
	{
		$this->Id = $Id;
		$zaznam = $this->database->table('zivocich')->get($Id);
		$zaznam = $zaznam->toArray();

		//Prevod datumu z databaze na korespondujuci datum pre uzivatela
		if($zaznam['datumNarodenia'] != null)
		{
			$datum = date_parse($zaznam['datumNarodenia']); //iba roky mesiace a dni
			$rok =  $datum['year'];
			$mesiac = $datum['month'];
			$den = $datum['day'];
			$zaznam['datumNarodenia'] = $rok . '-' . $mesiac . '-' . $den;
		}
		//Prevod datumu z databaze na korespondujuci datum pre uzivatela
		if($zaznam['datumUmrtia'] != null)
		{
			$datum = date_parse($zaznam['datumUmrtia']); //iba roky mesiace a dni
			$rok =  $datum['year'];
			$mesiac = $datum['month'];
			$den = $datum['day'];
			$zaznam['datumUmrtia'] = $rok . '-' . $mesiac . '-' . $den;
		}

		$this["editovatForm"]->setDefaults($zaznam);
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
		$this->redirect('Zivocich:editovat', $this->Id);
	}

	protected function createComponentVymazatButton()
	{
		$form = new Form;
		$form->addSubmit('vymazat', 'Vymazať')->setAttribute('class', 'btn btn-danger');;

		$form->onSuccess[] = array($this, 'uspesneVymazatButton');
		return $form;
	}

	public function uspesneVymazatButton(Form $form, $hodnoty)
	{
		//vymazem aj ostatne zaznamy daneho zivociha v inch tabulkach
		$this->database->table('staraSa')->where('IDZivocicha', $this->Id)->delete();
		$this->database->table('testoval')->where('IDZivocicha', $this->Id)->delete();
		$this->database->table('zivocich')->where('IDZivocicha', $this->Id)->delete();
		$form->getPresenter()->redirect('Zivocich:vypis');
	}

	protected function createComponentEditovatForm()
	{
		$this->tovarna = new EditovatZivocichaForm($this->database, $this->Id);
		$form = $this->tovarna->vytvorit();
		return $form;
	}
	
	protected function createComponentPridatStaraSa()
	{
		$form = new Form;

		$hodnoty = array();
		if($this->getUser()->roles[0] == 'riaditeľ') //prihlaseny je riaditel moze pridavat vsektych zamestnancov 
		{
			$prvky = $this->database->table('zamestnanec'); //kovli select boxu si ziskam vsetkych existujucich zamestnancovv db
			foreach($prvky as $prvok)
			{
				$hodnoty[$prvok->RodneCislo] = $prvok->meno . ' ' .$prvok->priezvisko;
			}
		}
		else //prihlaseny je zamestanec moze pridavat iba sam seba
		{
			$hodnoty[$this->getUser()->id] = $this->getUser()->getIdentity()->data['meno'];
		}
		$form->addSelect('RodneCislo', 'Zamestnanec:', $hodnoty);

		$form->addSubmit('pridat', 'Pridať');

		$form->onSuccess[] = array($this, 'uspesneStaraSa');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	public function uspesneStaraSa(Form $form, $hodnoty)
	{
		$hodnoty->IDZivocicha = $this->Id;
		if($this->database->table('staraSa')->where('RodneCislo', $hodnoty->RodneCislo)->where('IDZivocicha', $this->Id)->count() == 0) //ak tam v db tabulke taky zanznam este neni tak mozem pridat
		{
			$this->database->table('staraSa')->insert($hodnoty);
		}
		$this->redirect('Zivocich:viac', $this->Id);
	}

	protected function createComponentOdstranitStaraSaButton()
	{
		return new Multiplier(function ($RodneCislo)
		{
			$form = new Form;
			$form->addSubmit('odstranit', 'Odstrániť')->setAttribute('class', 'btn btn-danger');
			$form->addHidden('RodneCislo')->setValue($RodneCislo);;

			$form->onSuccess[] = array($this, 'uspesneOdstranitStaraSa');
			return $form;
		});
	}

	public function uspesneOdstranitStaraSa($form)
	{
		$this->database->table('staraSa')->where('IDZivocicha', $this->Id)->where('RodneCislo', $form['RodneCislo']->getValue())->delete();
	}

}
