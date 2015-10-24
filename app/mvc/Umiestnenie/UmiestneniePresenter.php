<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\ViacButton;
use App\Forms\VytvoritUmiestnenieForm;
use App\Forms\EditovatUmiestnenieForm;
use Test\Bs3FormRenderer;

/*
 * Presenter na vypis umiestneni, pridanie, editovanie...
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class UmiestneniePresenter extends BasePresenter
{
	private $database;
	public $Id; //id umiestnenia, pre presenter viac info, aby som vedel o com chcem viac info
	private $tovarna; //aby som mohol naplnit form default hodnotami

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	/*
	 * Iba presmeruje na iny presenter
	 */
	public function actionDefault()
	{
		$this->redirect('Umiestnenie:vypis');
	}

	/******************* Vypis ***********************/
	/*
	 * Presenter na vypis umiestneni
	 */
	public function renderVypis()
	{
		if(!$this->getUser()->isLoggedIn()) //uzivatel neni prihlaseny
		{
			$this->redirect('Homepage:prihlasenie');
		}
		$this->template->umiestnenia = $this->database->query('SELECT * FROM umiestnenie NATURAL JOIN klietka UNION SELECT * FROM umiestnenie NATURAL JOIN vybeh');
	}

	/*
	 * Vytvori viac button
	 * Vracia: vytvoreny button
	 */
	protected function createComponentViacButton()
	{
		return new Multiplier(function ($Id)
		{
			$form = (new ViacButton($this->database, $Id, 'Umiestnenie:viac'));
			return $form->vytvorit();
		});
	}

	/*
	 * Vytvori form na pridavanie kliekty
	 * Vracia: vytvoreny form
	 */
	protected function createComponentVytvoritKliektuForm()
	{
		$form = (new VytvoritUmiestnenieForm($this->database, 0));
		return $form->vytvorit();
	}

	/*
	 * Vytvori form na pridavanie vybehu
	 * Vracia: vytvoreny form
	 */
	protected function createComponentVytvoritVybehForm()
	{
		$form = (new VytvoritUmiestnenieForm($this->database, 1));
		return $form->vytvorit();
	}

	/******************* Vypis volne *******************/
	/*
	 * Presenter na vypis iba volnych umiestneni
	 */
	public function renderVypisVolne()
	{
		if(!$this->getUser()->isLoggedIn()) //uzivatel neni prihlaseny
		{
			$this->redirect('Homepage:prihlasenie');
		}
		$this->template->umiestnenia = $this->database->query('SELECT * FROM umiestnenie U WHERE 0 = (SELECT COUNT(*) FROM zivocich Z WHERE U.IDUmiestnenia = Z.IDUmiestnenia)');
	}

	/******************* Viac ************************/
	/*
	 * Presenter na vypis viac informacii
	 * Id: id umiestnenia, o ktorom cheme vediet viac
	 */
	public function renderViac($Id)
	{
		if(!$this->getUser()->isLoggedIn()) //uzivatel neni prihlaseny
		{
			$this->redirect('Homepage:prihlasenie');
		}
		$this->template->umiestnenie = $this->database->table('umiestnenie')->get($Id);
		$this->template->zivocichy = $this->database->table('zivocich')->where('IDUmiestnenia', $Id);
		$this->template->klietka = $this->database->table('klietka')->get($Id);
		$this->template->vybeh = $this->database->table('vybeh')->get($Id);

		$this->template->zamestnanci = $this->database->query('SELECT * FROM spravuje NATURAL JOIN zamestnanec WHERE IDUmiestnenia = ' . $Id);
	}

	/*
	 * Presenter na vypis viac informacii
	 * Id: id umiestnenia, o ktorom cheme vediet viac
	 */
	public function actionViac($Id)
	{
		$this->Id = $Id;

		if($this->database->table('klietka')->get($this->Id)) //ak je umiestnenie typu klietka, nasiel som zaznam v db v tabulke klietka tk nastavim mod na 0
		{
			$mod = 0;
		}
		else //inak je typu vybeh mod je 1
		{
			$mod = 1;
		}

		$this->template->mod = $mod; //predam mod aby som sa vedel aj v sablone podla toho riadit a zostavovat
		$zaznam = $this->database->table('umiestnenie')->get($Id);
		$zaznam = $zaznam->toArray();

		if($mod == 0) //pridavam form kliektu a naplnam
		{
			$this["editovatKlietkuForm"]->components['umiestnenie']->setDefaults($zaznam);
			$zaznam = $this->database->table('klietka')->get($Id);
			$zaznam = $zaznam->toArray();
			$this["editovatKlietkuForm"]->components['klietka']->setDefaults($zaznam);
		}
		else //pridavam form vybehu a naplnam dafaulnymi z db
		{
			$this["editovatVybehForm"]->components['umiestnenie']->setDefaults($zaznam);
			$zaznam = $this->database->table('vybeh')->get($Id);
			$zaznam = $zaznam->toArray();
			$this["editovatVybehForm"]->components['vybeh']->setDefaults($zaznam);
		}

		$this->tovarna->Id = $Id;
	}

	/*
	 * Vytvori button na vymazavanie
	 * Vracia: vytvoreny button
	 */
	protected function createComponentVymazatButton()
	{
		$form = new Form;
		$form->addSubmit('vymazat', 'Vymazať')->setAttribute('class', 'btn btn-danger');

		$form->onSuccess[] = array($this, 'uspesneVymazatButton');
		return $form;
	}

	/*
	 * Udalost po uspesnom odoslani vymazavacieho buttonu
	 * form: samotny form
	 * hodnoty: hondoty formu
	 */
	public function uspesneVymazatButton(Form $form, $hodnoty)
	{
		if($this->database->table('zivocich')->where('IDUmiestnenia', $this->Id)->count() == 0) //umiestnenie mozem vymazt iba ak neobsahuje ziadnych zivocichov
		{
			$this->database->table('klietka')->where('IDUmiestnenia', $this->Id)->delete();
			$this->database->table('vybeh')->where('IDUmiestnenia', $this->Id)->delete();
			$this->database->table('spravuje')->where('IDUmiestnenia', $this->Id)->delete();
			$this->database->table('umiestnenie')->where('IDUmiestnenia', $this->Id)->delete();
			$form->getPresenter()->redirect('Umiestnenie:vypis');
		}
		else //obshauje zivocichov, tak zobrazim spravu
		{
			$form->getPresenter()->flashMessage('Ak chcete odstrániť toto umiestnenie, najprv premiestnite všetky živočíchy z tohoto umiestnenia!');
		}
	}

	/*
	 * Vytvori formna editovanie klietky
	 * Vracia: vytvoreny form
	 */
	protected function createComponentEditovatKlietkuForm()
	{
		$this->tovarna = (new EditovatUmiestnenieForm($this->database, 0));
		$form = $this->tovarna->vytvorit();
		return $form;
	}

	/*
	 * Vytvori form na editovanie vybehu
	 * Vracia: vytvorney form
	 */
	protected function createComponentEditovatVybehForm()
	{
		$this->tovarna = (new EditovatUmiestnenieForm($this->database, 1));
		$form = $this->tovarna->vytvorit();
		return $form;
	}

	/*
	 * Vytvori form na rpdiavanie vztahov, kto spravuje toto uiestnenie
	 * Vracia: vytvorneny form
	 */
	protected function createComponentPridatSpravuje()
	{
		$form = new Form;

		$hodnoty = array();
		if($this->getUser()->roles[0] == 'riaditeľ') //ak som riaditel mozem pridavat vsetkych zamestnancov na spravovanie
		{
			$prvky = $this->database->table('zamestnanec'); //ziskam si zamestnancov a napnam pole pre pouzitie v select boxe, aby som mohol z nich vyberat
			foreach($prvky as $prvok)
			{
				$hodnoty[$prvok->RodneCislo] = $prvok->meno . ' ' . $prvok->priezvisko;
			}
		}
		else //ak som iba zamestnanec, tak mozem pridavat iba sebe umiestnenia na spravovanie
		{
			$hodnoty[$this->getUser()->id] = $this->getUser()->getIdentity()->data['meno'];
		}

		$form->addSelect('RodneCislo', 'Rodné číslo:', $hodnoty);

		$form->addSubmit('pridat', 'Pridať');

		$form->onSuccess[] = array($this, 'uspesneSpravuje');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	/*
	 * Udalost po uspensom odoslani spravovacieho formu
	 * form: samotny form
	 * hodnoty: hodnoty formu
	 */
	public function uspesneSpravuje(Form $form, $hodnoty)
	{
		$hodnoty->IDUmiestnenia = $this->Id;
		if($this->database->table('spravuje')->where('RodneCislo', $hodnoty->RodneCislo)->where('IDUmiestnenia', $this->Id)->count() == 0) //este sa taky zaznam v db nenachadza tak vlozim
		{
			$this->database->table('spravuje')->insert($hodnoty);
		}
		$this->flashMessage('Úspešne pridané!', 'uspech');
		$this->redirect('Umiestnenie:viac', $this->Id);
	}	

	/*
	 * Vytvori button na odstranovanie vztahu spravovania, teda kto spravuje toto umiestnenie
	 * Vracia: vytvoreny form
	 */
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

	/*
	 * Udalost po uspesnom odoslani odstraovacieho buttonu spravovania
	 * form: samotny form
	 */
	public function uspesneOdstranitSpravuje($form)
	{
		$this->database->table('spravuje')->where('IDUmiestnenia', $this->Id)->where('RodneCislo', $form['RodneCislo']->getValue())->delete();
		$this->flashMessage('Úspešne odstránené!', 'uspech');
		$this->redirect('Umiestnenie:viac', $this->Id);
	}
}
