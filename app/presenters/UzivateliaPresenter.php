<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\VytvoritUzivatelaForm;
use App\Forms\VymazatUzivatelaButton;
use App\Forms\ViacButton;
use App\Forms\EditovatUzivatelaForm;

/*
 * Stranky s uzivatelmi a prislusnych akciami
 */
class UzivateliaPresenter extends BasePresenter
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
		$this->redirect('Uzivatelia:vypis');
	}

	/************************************ Vypis ****************************************/
	/*
	 * Stranka s vypisom uzivatelov a formom na pridavanie uzivatelov
	 */
	public function renderVypis()
	{
		$this->template->zamestnanci = $this->database->table('zamestnanec');
	}

	/*
	 * Vytvorenie formu na vytvorenie uzaivatela
	 */
	protected function createComponentVytvoritForm()
	{
		$form = (new VytvoritUzivatelaForm($this->database, $this))->vytvorit();
		return $form;
	}

	/*
	 * Vytvorenie buttonu na eitovanie uzivatela
	 */
	protected function createComponentViacButton()
	{
		return new Multiplier(function ($RodneCislo)
		{
			$form = (new ViacButton($this->database, $RodneCislo, 'Uzivatelia:viac'))->vytvorit();
			return $form;
		});
	}

	/********************************** Viac **********************************/

	public function renderViac($RodneCislo)
	{
		$this->template->zamestnanec = $this->database->table('zamestnanec')->get($RodneCislo);
	}

	public function actionViac($RodneCislo)
	{
		$this->RodneCislo = $RodneCislo;
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
		$this->redirect('Uzivatelia:editovat', $this->RodneCislo);
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
		$this->database->table('zamestnanec')->where('RodneCislo', $this->RodneCislo)->delete();
		$form->getPresenter()->redirect('Uzivatelia:vypis');
	}

	/********************************* Editovat  ***********************************/

	/*
	 * Stranka s viac informáciami
	 */
	public function actionEditovat($RodneCislo)
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

	/*
	 * Vytvorenie formu na editovanie
	 */
	protected function createComponentEditovatForm()
	{
		$this->tovarna = new EditovatUzivatelaForm($this->database, $this->RodneCislo);
		$form = $this->tovarna->vytvorit();
		return $form;
	}

}
