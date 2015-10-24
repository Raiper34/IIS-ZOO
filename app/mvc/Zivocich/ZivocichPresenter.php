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
	private $Id; //id aby sme vedeli pre viac presenter, o ktorom zivocichovy chceme viac info

	/*
	 * Konstruktro triedy
	 */
	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	/*
	 * Iba rpesmeruje na spravny presenter
	 */
	public function actionDefault()
	{
		$this->redirect('Zamestnanec:vypis');
	}

	/************************************ Vypis ****************************************/
	/*
	 * Presenter na vypis zivocihcov
	 */
	public function renderVypis()
	{
		if(!$this->getUser()->isLoggedIn()) //uzivatel neni prihlaseny
		{
			$this->redirect('Homepage:prihlasenie');
		}
		$this->template->zivocichi = $this->database->table('zivocich');
	}

	/*
	 * Vytvori form na pridavanie zivocichov
	 * Vracia: vytvoreny form
	 */
	protected function createComponentVytvoritForm()
	{
		$form = (new VytvoritZivocichaForm($this->database, $this));
		return $form->vytvorit();
	}

	/*
	 * Vytvori viac button
	 * Vracia: vytvorney button
	 */
	protected function createComponentViacButton()
	{
		return new Multiplier(function ($Id)
		{
			$form = (new ViacButton($this->database, $Id, 'Zivocich:viac'));
			return $form->vytvorit();
		});
	}

	/********************************** Viac **********************************/
	/*
	 * Presneter na zobrazenie viac informaci o danom zivocichovi
	 * Id: id zivocicha, o ktorom cheme vediet viac
	 */
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

	/*
	 * Presneter na zobrazenie viac informaci o danom zivocichovi
	 * Id: id zivocicha, o ktorom cheme vediet viac
	 */
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

	/*
	 * Vytvori button na vymazavanie zivocicha
	 * Vracia: vytvoreny button
	 */
	protected function createComponentVymazatButton()
	{
		$form = new Form;
		$form->addSubmit('vymazat', 'Vymazať')->setAttribute('class', 'btn btn-danger');;

		$form->onSuccess[] = array($this, 'uspesneVymazatButton');
		return $form;
	}

	/*
	 * Udalost po uspesnom odoslani vymazavacieho tlacidla
	 * form: samotny form
	 * hodnoty: naplnene hodnoty formu
	 */
	public function uspesneVymazatButton(Form $form, $hodnoty)
	{
		//vymazem aj ostatne zaznamy daneho zivociha v inch tabulkach
		$this->database->table('staraSa')->where('IDZivocicha', $this->Id)->delete();
		$this->database->table('testoval')->where('IDZivocicha', $this->Id)->delete();
		$this->database->table('zivocich')->where('IDZivocicha', $this->Id)->delete();
		$form->getPresenter()->flashMessage('Úspešne odstránené!', 'uspech');
		$form->getPresenter()->redirect('Zivocich:vypis');
	}

	/*
	 * Vytvori form na editovanie zivocicha
	 * Vacia: vytovreny form
	 */
	protected function createComponentEditovatForm()
	{
		$this->tovarna = new EditovatZivocichaForm($this->database, $this->Id);
		$form = $this->tovarna->vytvorit();
		return $form;
	}
	
	/*
	 * Vytvori form na pridavanie kto sa stara o tohoto zivocicha
	 * Vracia: vytvoreny form
	 */
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

	/*
	 * Udalost po uspesnom odoslani formu na pridavanie kto sa o zivocicha stara
	 * form: samotny form
	 * hodnoty: naplnene hodnoty formu
	 */
	public function uspesneStaraSa(Form $form, $hodnoty)
	{
		$hodnoty->IDZivocicha = $this->Id;
		if($this->database->table('staraSa')->where('RodneCislo', $hodnoty->RodneCislo)->where('IDZivocicha', $this->Id)->count() == 0) //ak tam v db tabulke taky zanznam este neni tak mozem pridat
		{
			$this->database->table('staraSa')->insert($hodnoty);
		}
		$form->getPresenter()->flashMessage('Úspešne pridané!', 'uspech');
		$this->redirect('Zivocich:viac', $this->Id);
	}

	/*
	 * Button na odstranenie kto sa stara o zivocicha
	 * Vracia: vytvorney form
	 */
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

	/*
	 * Udalost po suepsnom odoslani buttonu na odstranenie kto sa o zivocicha strara
	 */
	public function uspesneOdstranitStaraSa($form)
	{
		$this->database->table('staraSa')->where('IDZivocicha', $this->Id)->where('RodneCislo', $form['RodneCislo']->getValue())->delete();
		$form->getPresenter()->flashMessage('Úspešne odstránené!', 'uspech');
		$this->redirect('Zivocich:viac', $this->Id);
	}

}
