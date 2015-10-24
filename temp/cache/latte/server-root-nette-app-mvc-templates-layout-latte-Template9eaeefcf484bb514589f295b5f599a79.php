<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/@layout.latte

class Template9eaeefcf484bb514589f295b5f599a79 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('e102c481a4', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block head
//
if (!function_exists($_b->blocks['head'][] = '_lb032a192421_head')) { function _lb032a192421_head($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb9a4d6458be_scripts')) { function _lb9a4d6458be_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//nette.github.io/resources/js/netteForms.min.js"></script>
	<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/main.js"></script>
	<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/bootstrap.min.js"></script>
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
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<title>IIS FIT ZOO</title>

	<!--Vlastne -->
	<link rel="stylesheet" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/style.css">
	<link rel="shortcut icon" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<meta name="viewport" content="width=device-width">

	<!-- Bootstrap -->
	<link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/bootstrap.min.css" rel="stylesheet">

	<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['head']), $_b, get_defined_vars())  ?>

</head>

<body>
	
	<!-- Navbar -->
<?php if ($user->isLoggedIn()) { ?>
        <div class="navbar navbar-inverse menu" id="moj-navbar">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand" id="logo-small">IIS ZOO FIT</span>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav menu-button">
<?php if ($user->identity->roles[0] == 'riaditeľ') { ?>
                            <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Zamestnanec:vypis"), ENT_COMPAT) ?>">Zamestnanci</a><li>
<?php } ?>
                            <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Umiestnenie:vypis"), ENT_COMPAT) ?>">Umiestnenia</a><li>
                            <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Druh:vypis"), ENT_COMPAT) ?>">Druhy živočíchov</a><li>
                            <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Zivocich:vypis"), ENT_COMPAT) ?>">Živočíchy</a><li>
                            <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Test:vypis"), ENT_COMPAT) ?>">Testy</a><li>
                    </ul>
                    <ul class="nav navbar-nav menu-button navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo Latte\Runtime\Filters::escapeHtml($user->identity->meno, ENT_NOQUOTES) ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" id="mydropdown">
                                <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Zamestnanec:viac", array($user->identity->id)), ENT_COMPAT) ?>">Profil</a><li>
                                <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Homepage:odhlasit"), ENT_COMPAT) ?>">Odhlásiť</a><li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
<?php } ?>

    <!-- Flash messages -->
<?php $iterations = 0; foreach ($flashes as $flash) { ?>    <div>
        <div class="container">
<?php if ($flash->type == "uspech") { ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    <?php echo Latte\Runtime\Filters::escapeHtml($flash->message, ENT_NOQUOTES) ?>

                </div>
<?php } else { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    <?php echo Latte\Runtime\Filters::escapeHtml($flash->message, ENT_NOQUOTES) ?>

                </div>
<?php } ?>
        </div>
    </div>
<?php $iterations++; } ?>

    <!-- Obsah -->
	<div class="container">
<?php Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'content', $template->getParameters()) ?>
    </div>

<?php call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>

    <br>
</body>
</html>
<?php
}}