<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Test\Bs3FormRenderer;

/*
 * Test presenter, na vypis testov, pridavanie...
 * Autor: Filip Gulán xgulan00@stud.fit.vutbr.cz
 */
class TestPresenter extends BasePresenter
{
	private $database;
	public $Id; //id testu

	/*
	 * Konstruktor triedy
	 */
	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	/*
	 * Iba presmeruje na spravny presenter
	 */
	public function actionDefault()
	{
		$this->redirect('Test:vypis');
	}

	/******************* Vypis ***********************/
	/*
	 * Presentr na vypis testov z db
	 */
	public function renderVypis()
	{
		if(!$this->getUser()->isLoggedIn()) //uzivatel neni prihlaseny presmerujem
		{
			$this->redirect('Homepage:prihlasenie');
		}
		//Vytiahnem si z databaze test aj s vsetkymi menami, preto joinujem 3 tabulky
		$this->template->testy = $this->database->query(
			'SELECT T.IDTestu, T.RodneCislo, T.IDZivocicha, Zi.meno as menoZivocicha, Za.meno as menoZamestnanca, Za.priezvisko, T.hmotnostZivocicha, T.rozmerZivocicha, T.datumTestu 
			FROM testoval T, zamestnanec Za, zivocich Zi 
			WHERE T.RodneCislo = Za.RodneCislo and T.IDZivocicha = Zi.IDZivocicha;'
		);
	}

	/*
	 * Vytvori form na pridavanie testov
	 * Vracia: vytvoreny form
	 */
	protected function createComponentVytvoritForm()
	{
		$form = new Form;

		//Zivocich
		$hodnotyZivocich = array();
		$zivocichy = $this->database->table('zivocich'); //ziskam si vsetkych zivocichov
		foreach($zivocichy as $zivocich) //a pridam ich do pola aby mohli byt v select boxe
		{
			$hodnotyZivocich[$zivocich->IDZivocicha] = $zivocich->meno;
		}
		$form->addSelect('IDZivocicha', '*Živočích:', $hodnotyZivocich)->setRequired();

		//Zamestnanec
		$hodnotyZamestnancov = array();
		if($this->getUser()->roles[0] == 'riaditeľ') //ak som riaditel tak mozem pridavat za kazdeho
		{
			$zamestnanci = $this->database->table('zamestnanec'); //ziskam si vsetkych zamestnancov
			foreach($zamestnanci as $zamestnanec)
			{
				$hodnotyZamestnancov[$zamestnanec->RodneCislo] = $zamestnanec->meno . " " . $zamestnanec->priezvisko;
			}
		}
		else //neni som riaditel, mozem testovat iba pod svojim menom
		{
			$hodnotyZamestnancov[$this->getUser()->id] = $this->getUser()->getIdentity()->data['meno'];
		}

		$form->addSelect('RodneCislo', '*Zamestnanec:', $hodnotyZamestnancov)->setRequired();

		$form->addText('hmotnostZivocicha', 'Hmotnosť živočícha:')->addCondition(Form::FILLED)->addRule(Form::FLOAT, 'Pole musi obsahovať iba čísla!');
		$form->addText('rozmerZivocicha', 'Rozmer živočícha:')->addCondition(Form::FILLED)->addRule(Form::FLOAT, 'Pole musi obsahovať iba čísla!');
		$form->addText('datumTestu', '*Dátum testu(YYYY-MM-DD):')->setRequired()->addRule(Form::PATTERN, 'Nesprávny fomrát', '([0-9]){4}-([0-9]){2}-([0-9]){2}');
		
		$form->addSubmit('vytvorit', 'Vytvoriť');
		$form->onSuccess[] = array($this, 'uspesne');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	/*
	 * Udalost pri uspesnom odoslani formu
	 */
	public function uspesne(Form $form, $hodnoty)
	{
		foreach ($hodnoty as &$hodnota) if ($hodnota === '') $hodnota = NULL; //prazdne polia budu nully a nie praznde stringy ukladane do db
		$this->database->table('testoval')->insert($hodnoty);
		$form->getPresenter()->flashMessage('Úspešne pridané!', 'uspech');
		$this->redirect('Test:vypis');
	}

}
