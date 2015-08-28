<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/Test/vypis.latte

class Templateeacab19e4935d6c5573319cfa54afbae extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('8adc5513f0', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb0ed93c508f_content')) { function _lb0ed93c508f_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal1">
  Pridať
</button>
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Pridať</h4>
      </div>
      <div class="modal-body">
<?php $_l->tmp = $_control->getComponent("vytvoritForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
      </div>
    </div>
  </div>
</div>

<table class="table table-bordered table-hover">
    <tr>
        <td>Testovaný živočích</td>
        <td>Testujúci zamestnanec</td>
        <td>Hmotnosť živočícha</td>
        <td>Rozmer živočícha</td>
        <td>Dátum testu</td>
    </tr>
<?php $iterations = 0; foreach ($testy as $test) { ?>
    <tr>
        <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Zivocich:viac", array($test->IDZivocicha)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($test->menoZivocicha, ENT_NOQUOTES) ?></a></td>
        <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Zamestnanec:viac", array($test->RodneCislo)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($test->menoZamestnanca, ENT_NOQUOTES) ?>
 <?php echo Latte\Runtime\Filters::escapeHtml($test->priezvisko, ENT_NOQUOTES) ?></a></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($test->hmotnostZivocicha, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($test->rozmerZivocicha, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($test->datumTestu, ENT_NOQUOTES) ?></td>
    <tr>
<?php $iterations++; } ?>
</table>
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