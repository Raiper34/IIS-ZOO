<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/Zivocich/viac.latte

class Template04a5fa1cca74627b74715c54bb7bbd1d extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('a6d9799ef5', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbd2683a82ae_content')) { function _lbd2683a82ae_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
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
<strong>Identifikačné číslo:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zivocich->IDZivocicha, ENT_NOQUOTES) ?> <br>
<strong>Meno:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zivocich->meno, ENT_NOQUOTES) ?> <br>
<strong>Dátum Narodenia:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zivocich->datumNarodenia, ENT_NOQUOTES) ?> <br>
<strong>Dátum úmrtia:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zivocich->datumUmrtia, ENT_NOQUOTES) ?> <br>
<strong>Trieda:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zivocich->trieda, ENT_NOQUOTES) ?> <br>
<strong>Rad:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zivocich->rad, ENT_NOQUOTES) ?> <br>
<strong>Čelaď:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zivocich->celad, ENT_NOQUOTES) ?> <br>
<strong>Rod:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zivocich->rod, ENT_NOQUOTES) ?> <br>
<strong>Druh:</strong> <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Druh:viac", array($druh->IDDruhuZivocicha)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($druh->nazov, ENT_NOQUOTES) ?></a> <br>
<strong>Umiestnenie:</strong> <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Umiestnenie:viac", array($umiestnenie->IDUmiestnenia)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->nazov, ENT_NOQUOTES) ?></a> <br>






<h3>O tohoto živočícha sa stará:</h3>
<table class="table table-bordered table-hover">
	<tr>
	    <th>Zamestnanec</th>
	</tr>
<?php $iterations = 0; foreach ($zamestnanci as $zamestnanec) { ?>
	<tr>
		<td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Zamestnanec:viac", array($zamestnanec->RodneCislo)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->meno, ENT_NOQUOTES) ?>
 <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->priezvisko, ENT_NOQUOTES) ?></a></td>
<?php if ($user->identity->roles[0] == 'riaditeľ' || $user->id == $zamestnanec->RodneCislo) { ?>
			<td><?php $_l->tmp = $_control->getComponent("odstranitStaraSaButton-$zamestnanec->RodneCislo"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?></td>
<?php } ?>
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








<h3>Bol testovaný:</h3>
<table class="table table-bordered table-hover">
	<tr>
	    <th>Zamestnanec, ktorý test vykonal</th>
	    <th>Hmotnosť živočícha</th>
	    <th>Rozmer živočícha</th>
	    <th>Dátum Testu</th>
	</tr>
<?php $iterations = 0; foreach ($testy as $test) { ?>
	<tr>
		<td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Zamestnanec:viac", array($test->RodneCislo)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($test->meno, ENT_NOQUOTES) ?> <?php echo Latte\Runtime\Filters::escapeHtml($test->priezvisko, ENT_NOQUOTES) ?></a></td> 
		<td><?php echo Latte\Runtime\Filters::escapeHtml($test->hmotnostZivocicha, ENT_NOQUOTES) ?></td> 
		<td><?php echo Latte\Runtime\Filters::escapeHtml($test->rozmerZivocicha, ENT_NOQUOTES) ?></td> 
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