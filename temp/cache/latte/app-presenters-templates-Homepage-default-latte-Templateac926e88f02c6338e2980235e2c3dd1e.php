<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\presenters/templates/Homepage/default.latte

class Templateac926e88f02c6338e2980235e2c3dd1e extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('b65b2f65e4', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbf45dfcee8a_content')) { function _lbf45dfcee8a_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><table>
<?php $iterations = 0; foreach ($pouzivatelia as $pouzivatel) { ?>
    <tr>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($pouzivatel->id, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($pouzivatel->meno, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($pouzivatel->opravnenie, ENT_NOQUOTES) ?></td>
        <td><?php $_l->tmp = $_control->getComponent("vymazatUzivatela-$pouzivatel->id"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?></td>
    <tr>
<?php $iterations++; } ?>
</table>

<?php $_l->tmp = $_control->getComponent("vytvoritUzivatela"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;$_l->tmp = $_control->getComponent("prihlasenie"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;
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