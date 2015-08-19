<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\VytvoritUzivatelaForm;
use App\Forms\VymazatUzivatelaButton;
use App\Forms\EditovatUzivatelaButton;
use App\Forms\EditovatUzivatelaForm;

/*
 * Stranka s uzivatelmi a prislusnych akciami
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

	/*
	 * Render vypis sablony
	 */
	public function renderVypis()
	{
		$this->template->zamestnanci = $this->database->table('zamestnanec');
	}

	
	public function actionEditovanie($RodneCislo)
	{
		$this->RodneCislo = $RodneCislo;
		$zaznam = $this->database->table('zamestnanec')->get($RodneCislo);
		$zaznam = $zaznam->toArray();
		$datum = date_parse($zaznam['datumNarodenia']); //iba roky mesiace a dni
		$rok =  $datum['year'];
		$mesiac = $datum['month'];
		$den = $datum['day'];
		$zaznam['datumNarodenia'] = $rok . '-' . $mesiac . '-' . $den;
		$this["editovatForm"]->setDefaults($zaznam);
		$this->tovarna->RodneCislo = $RodneCislo;
	}


	/********************** Componenty *****************************/

	/*
	 * Vytvorenie formu na vytvorenie uzaivatela
	 */
	protected function createComponentVytvoritForm()
	{
		$form = (new VytvoritUzivatelaForm($this->database, $this))->vytvorit();
		return $form;
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

	/*
	 * Vytvorenie buttonu na vymazanie uzivatela
	 */
	protected function createComponentVymazatButton()
	{
		return new Multiplier(function ($RodneCislo)
		{
			$form = (new VymazatUzivatelaButton($this->database, $RodneCislo))->vytvorit();
			return $form;
		});
	}

	/*
	 * Vytvorenie buttonu na eitovanie uzivatela
	 */
	protected function createComponentEditovatButton()
	{
		return new Multiplier(function ($RodneCislo)
		{
			$form = (new EditovatUzivatelaButton($this->database, $RodneCislo))->vytvorit();
			return $form;
		});
	}

}
