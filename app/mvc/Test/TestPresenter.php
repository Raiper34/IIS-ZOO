<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Test\Bs3FormRenderer;

class TestPresenter extends BasePresenter
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
		$this->redirect('Test:vypis');
	}

	/******************* Vypis ***********************/
	public function renderVypis()
	{
		$this->template->testy = $this->database->query(
			'SELECT T.RodneCislo, T.IDZivocicha, Zi.meno as menoZivocicha, Za.meno as menoZamestnanca, Za.priezvisko, T.hmotnostZivocicha, T.rozmerZivocicha, T.datumTestu 
			FROM testoval T, zamestnanec Za, zivocich Zi 
			WHERE T.RodneCislo = Za.RodneCislo and T.IDZivocicha = Zi.IDZivocicha'
		);
	}

	protected function createComponentVytvoritForm()
	{
		$form = new Form;

		//Zivocich
		$hodnotyZivocich = array();
		$zivocichy = $this->database->table('zivocich');
		foreach($zivocichy as $zivocich)
		{
			$hodnotyZivocich[$zivocich->IDZivocicha] = $zivocich->meno;
		}
		$form->addSelect('IDZivocicha', 'Živočích:', $hodnotyZivocich);

		//Zamestnanec
		$hodnotyZamestnancov = array();
		$zamestnanci = $this->database->table('zamestnanec');
		foreach($zamestnanci as $zamestnanec)
		{
			$hodnotyZamestnancov[$zamestnanec->RodneCislo] = $zamestnanec->meno . " " . $zamestnanec->priezvisko;
		}
		$form->addSelect('RodneCislo', 'Zamestnanec:', $hodnotyZamestnancov);

		$form->addText('hmotnostZivocicha', 'Hmotnosť živočícha:')->setRequired()->addRule(Form::FLOAT, 'Pole musi obsahovať iba čísla!');;
		$form->addText('rozmerZivocicha', 'Rozmer živočícha:')->setRequired()->addRule(Form::FLOAT, 'Pole musi obsahovať iba čísla!');;
		$form->addText('datumTestu', 'Dátum testu(YYYY-MM-DD):')->setRequired()->addRule(Form::PATTERN, 'Nesprávny fomrát', '([0-9]){4}-([0-9]){2}-([0-9]){2}');;
		
		$form->addSubmit('vytvorit', 'Vytvoriť');
		$form->onSuccess[] = array($this, 'uspesne');
		$form->setRenderer(new Bs3FormRenderer);
		return $form;
	}

	public function uspesne(Form $form, $hodnoty)
	{
		$this->database->table('testoval')->insert($hodnoty);
		$this->redirect('Test:vypis');
	}

}
