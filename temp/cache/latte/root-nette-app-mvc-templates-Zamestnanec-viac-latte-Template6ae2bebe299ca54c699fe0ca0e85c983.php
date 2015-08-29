<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/Zamestnanec/viac.latte

class Template6ae2bebe299ca54c699fe0ca0e85c983 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('118ba062af', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb038e2b8113_content')) { function _lb038e2b8113_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div class="row">
	<div class="col-md-1">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal1">
		  Editovať
		</button>
		<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Eitovať</h4>
		      </div>
		      <div class="modal-body">
<?php $_l->tmp = $_control->getComponent("editovatForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	<div class="col-md-1">
<?php $_l->tmp = $_control->getComponent("vymazatButton"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
	</div>
</div>



<h3>Základné informácie:</h3>
<strong>Rodné číslo:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->RodneCislo, ENT_NOQUOTES) ?> <br>
<strong>Meno:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->meno, ENT_NOQUOTES) ?> <br>
<strong>Priezvisko:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->priezvisko, ENT_NOQUOTES) ?> <br>
<strong>Titul:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->titul, ENT_NOQUOTES) ?> <br>
<strong>Dátum narodenia:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->datumNarodenia, ENT_NOQUOTES) ?> <br>
<strong>Adresa:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->adresa, ENT_NOQUOTES) ?> <br>
<strong>Funkcia:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->funkcia, ENT_NOQUOTES) ?> <br>
<strong>IBAN:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->IBAN, ENT_NOQUOTES) ?> <br>





<h3>Spravuje umiestnenia:</h3>
<table class="table table-bordered table-hover">
	<tr>
	    <th>Umiestnenie</th>
	</tr>
<?php $iterations = 0; foreach ($umiestnenia as $umiestnenie) { ?>
	<tr>
		<td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Umiestnenie:viac", array($umiestnenie->IDUmiestnenia)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->nazov, ENT_NOQUOTES) ?></a></td>  
	</tr>
<?php $iterations++; } ?>
</table>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal2">
	Pridať
</button>
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <h4 class="modal-title" id="myModalLabel">Eitovať</h4>
			</div>
			     <div class="modal-body">
<?php $_l->tmp = $_control->getComponent("pridatSpravuje"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
			    </div>
		</div>
	</div>
</div>




<h3>Stará sa o:</h3>
<table class="table table-bordered table-hover">
	<tr>
	    <th>Živočích</th>
	</tr>
<?php $iterations = 0; foreach ($zivocichy as $zivocich) { ?>
	<tr>
		<td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Zivocich:viac", array($zivocich->IDZivocicha)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($zivocich->meno, ENT_NOQUOTES) ?></a></td>  
		<td><?php $_l->tmp = $_control->getComponent("odstranitStaraSaButton-$zivocich->IDZivocicha"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?></td>
	</tr>
<?php $iterations++; } ?>
</table>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal3">
	Pridať
</button>
<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <h4 class="modal-title" id="myModalLabel">Eitovať</h4>
			</div>
			     <div class="modal-body">
<?php $_l->tmp = $_control->getComponent("pridatStaraSa"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
			    </div>
		</div>
	</div>
</div>




<h3>Testoval:</h3>
<table class="table table-bordered table-hover">
	<tr>
	    <th>Živočích, ktorého testoval</th>
	    <th>Dátum Testu</th>
	</tr>
<?php $iterations = 0; foreach ($testy as $test) { ?>
	<tr>
		<td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Zivocich:viac", array($test->IDZivocicha)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($test->meno, ENT_NOQUOTES) ?></a></td>  
		<td><?php echo Latte\Runtime\Filters::escapeHtml($test->datumTestu, ENT_NOQUOTES) ?></td>
	</tr>
<?php $iterations++; } ?>
</table>
<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Test:vypis"), ENT_COMPAT) ?>" class="btn btn-primary">Pridať test</a>
<?php
}}

//
// end of blocks
//

// template extending

$_l->extends = empty($_g->extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $_g->extended = TRUE;

if ($_l->extends) { ob_start();}

// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIRuntime::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}