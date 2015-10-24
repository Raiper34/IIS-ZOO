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
 * Presenter zamestnane, vypis zamestnancov editacia...
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class ZamestnanecPresenter extends BasePresenter
{
	private $database;
	private $tovarna;
	private $RodneCislo; //rodne cislo pre viac presenter, aby sme vedeli o kom chceme viac info

	/*
	 * Konstruktor triedy
	 */
	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	/*
	 * Iba presmeruje na druhy presenter
	 */
	public function actionDefault()
	{
		$this->redirect('Zamestnanec:vypis');
	}

	/************************************ Vypis ****************************************/
	/*
	 * Presenter na vypis zamestnancov
	 */
	public function renderVypis()
	{
		if(!$this->getUser()->isLoggedIn()) //uzivatel neni prihlaseny 
		{
			$this->redirect('Homepage:prihlasenie');
		}
		else if($this->getUser()->roles[0] != 'riaditeľ') //uzivatel je prihlaseny ale je to zamestnanec a ten nema prava
		{
			$this->redirect('Homepage:prava');
		}
		$this->template->zamestnanci = $this->database->table('zamestnanec');
	}

 	/*
 	 * Vytvori form na pridavanie zamestnancov
 	 * Vracia: vytvoreny form
 	 */
	protected function createComponentVytvoritForm()
	{
		$form = (new VytvoritZamestnancaForm($this->database, $this));
		return $form->vytvorit();
	}

	/*
	 * Vytvori viac button, na prejdenie k rpesenteru s viac info
	 * Vracia: vytvoreny button
	 */
	protected function createComponentViacButton()
	{
		return new Multiplier(function ($RodneCislo)
		{
			$form = (new ViacButton($this->database, $RodneCislo, 'Zamestnanec:viac'));
			return $form->vytvorit();
		});
	}

	/********************************** Viac **********************************/
	/*
	 * Presenter na zobraznie viac informacii daneho zamestnanca
	 * RodneCislo: rodne cislo daneho zamestnanca, o ktorom chceme viac info
	 */
	public function renderViac($RodneCislo)
	{
		if(!$this->getUser()->isLoggedIn()) //uzivatel neni prihlaseny
		{
			$this->redirect('Homepage:prihlasenie');
		}
		else if($this->getUser()->roles[0] != 'riaditeľ') //prihlaseny je zamestnanec
		{
			if($this->getUser()->id != $RodneCislo) //zamestnanec moze prezerat iba svoj profil, teda ak je to iny profil nema prava
			{
				$this->redirect('Homepage:prava');
			}
		}
		$this->template->zamestnanec = $this->database->table('zamestnanec')->get($RodneCislo);

		$this->template->testy = $this->database->query('SELECT * FROM testoval NATURAL JOIN zivocich WHERE RodneCislo = ' . $RodneCislo);

		$this->template->umiestnenia = $this->database->query('SELECT * FROM spravuje NATURAL JOIN umiestnenie WHERE RodneCislo = ' . $RodneCislo);

		$this->template->zivocichy = $this->database->query('SELECT * FROM staraSa NATURAL JOIN zivocich WHERE RodneCislo = ' . $RodneCislo);
	}

	/*
	 * Presenter na zobraznie viac informacii daneho zamestnanca
	 * RodneCislo: rodne cislo daneho zamestnanca, o ktorom chceme viac info
	 */
	public function actionViac($RodneCislo)
	{
		$this->RodneCislo = $RodneCislo;
		$zaznam = $this->database->table('zamestnanec')->get($RodneCislo);
		$zaznam = $zaznam->toArray();

		if($zaznam['datumNarodenia'] != null) //datum je v db zadany
		{
			//Prevod datumu z databaze na korespondujuci datum pre uzivatela
			$datum = date_parse($zaznam['datumNarodenia']); //iba roky mesiace a dni
			$rok =  $datum['year'];
			$mesiac = $datum['month'];
			$den = $datum['day'];
			$zaznam['datumNarodenia'] = $rok . '-' . $mesiac . '-' . $den;
		}

		$this["editovatForm"]->setDefaults($zaznam);
		$this->tovarna->RodneCislo = $RodneCislo;
	}

	/*
	 * Vytvori button na odstranenie o koho sa zamestnanec ma starat
	 * Vracia: vytvoreny button
	 */
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

	/*
	 * Po uspesnom odoslani stara sa buttonu
	 * form: samotny form
	 */
	public function uspesneOdstranitStaraSa($form)
	{
		$this->database->table('staraSa')->where('RodneCislo', $this->RodneCislo)->where('IDZivocicha', $form['id']->getValue())->delete();
		$this->flashMessage('Úspešne odstránené!', 'uspech');
		$this->redirect('Zamestnanec:viac', $this->RodneCislo);
	}

	/*
	 * Vytvori button na odstrannenie ake umiestnenie zamestnanec spravuje
	 * Vracia: vytvoreny button
	 */
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

	/*
	 * Udalost po supensnom odoslani spravuje button
	 * form: samotny form
	 */
	public function uspesneOdstranitSpravuje($form)
	{
		$this->database->table('spravuje')->where('RodneCislo', $this->RodneCislo)->where('IDUmiestnenia', $form['id']->getValue())->delete();
		$this->flashMessage('Úspešne odstránené!', 'uspech');
		$this->redirect('Zamestnanec:viac', $this->RodneCislo);
	}

	/*
	 * Vytvori form pridavanie o koho sa zamestnanec stara
	 * vracia: vytvoreny form
	 */
	protected function createComponentPridatStaraSa()
	{
		$form = new Form;

		$hodnoty = array();
		$prvky = $this->database->table('zivocich'); //najdem vsetkych zivocichov a pridam ich do pola by som ich potom mohol vyberat v select boxe
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

	/*
	 * Udalost po uspensnom odoslani formu pridavanie stara sa
	 * form: samotny form
	 * hodnoty: hodnoty formu
	 */
	public function uspesneStaraSa(Form $form, $hodnoty)
	{
		$hodnoty->RodneCislo = $this->RodneCislo;
		if($this->database->table('staraSa')->where('RodneCislo', $this->RodneCislo)->where('IDZivocicha', $hodnoty->IDZivocicha)->count() == 0) //taky zanzma este neexistuje tak ho mozem pridat
		{
			$this->database->table('staraSa')->insert($hodnoty);
		}
		$form->getPresenter()->flashMessage('Úspešne pridané!', 'uspech');
		$this->redirect('Zamestnanec:viac', $this->RodneCislo);
	}

	/*
	 * Vytvori form na pridavanie ake umiestnenie zamestnanec spravuje
	 * Vracia: vytvoreny form
	 */
	protected function createComponentPridatSpravuje()
	{
		$form = new Form;

		$hodnoty = array();
		//najdem vsetky umiestnenia a pridam ich do pola by som ich potom mohol vyberat v select boxe
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

	/*
	 * Udalost po uspensom odoslani fomru na pridavanie ktore umeistnenie zamestnanec spravuje
	 * form: samotny form
	 * hodnoty: hondoty formu
	 */
	public function uspesneSpravuje(Form $form, $hodnoty)
	{
		$hodnoty->RodneCislo = $this->RodneCislo;
		if($this->database->table('spravuje')->where('RodneCislo', $this->RodneCislo)->where('IDUmiestnenia', $hodnoty->IDUmiestnenia)->count() == 0) //zamznam este neexistuje tak ho mozem pridat
		{
			$this->database->table('spravuje')->insert($hodnoty);
		}
		$form->getPresenter()->flashMessage('Úspešne pridané!', 'uspech');
		$this->redirect('Zamestnanec:viac', $this->RodneCislo);
	}

	/*
	 * Vytvori button na vymazavanie zamestnanca
	 * Vracia: vytvorney form
	 */
	protected function createComponentVymazatButton()
	{
		$form = new Form;
		$form->addSubmit('vymazat', 'Vymazať')->setAttribute('class', 'btn btn-danger');

		$form->onSuccess[] = array($this, 'uspesneVymazatButton');
		return $form;
	}

	/*
	 * Udalost po uspensom odoslani buttonu na vymazavnaie zamestnanca
	 * form: samotny form
	 * hodnoty: naplnene hodnoty formu
	 */
	public function uspesneVymazatButton(Form $form, $hodnoty)
	{
		//musim vymazat aj vsetky dalsie zaznamy v inych tabulkach daneho zamestnanca
		$this->database->table('testoval')->where('RodneCislo', $this->RodneCislo)->delete();
		$this->database->table('staraSa')->where('RodneCislo', $this->RodneCislo)->delete();
		$this->database->table('spravuje')->where('RodneCislo', $this->RodneCislo)->delete();
		$this->database->table('zamestnanec')->where('RodneCislo', $this->RodneCislo)->delete();
		$form->getPresenter()->flashMessage('Úspešne odstránené!', 'uspech');
		$form->getPresenter()->redirect('Zamestnanec:vypis');

	}

	/*
	 * Vytvori form na editovanie zamestnanca
	 * Vracia: vytvoreny form
	 */
	protected function createComponentEditovatForm()
	{
		$this->tovarna = new EditovatZamestnancaForm($this->database, $this->RodneCislo);
		$form = $this->tovarna->vytvorit();
		return $form;
	}

}
