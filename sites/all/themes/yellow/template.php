<?php
// $Id

require_once("common_methods.php");


global $language;
if (isset($language)) {
	$language->direction = LANGUAGE_LTR;
}

switch (get_drupal_major_version()) {
	case 5:
	  require_once("drupal5_theme_methods.php");
	  break;
	case 6:
	  require_once("drupal6_theme_methods.php");
	  break;
	case 7:
	  require_once("drupal7_theme_methods.php");
	  break;
    default:
		  break;
}

/* Common methods */

function get_drupal_major_version() {	
	$tok = strtok(VERSION, '.');
	//return first part of version number
	return (int)$tok[0];
}

function get_page_language($language) {
  if (get_drupal_major_version() >= 6) return $language->language;
  return $language;
}

function get_page_direction($language) {
  if (isset($language) && isset($language->dir)) { 
	  return 'dir="'.$language->dir.'"';
  }
  return 'dir="'.ltr.'"';
}

function get_full_path_to_theme() {
  return base_path().path_to_theme();
}

function get_artx_drupal_view() {
	if (get_drupal_major_version() == 7)
		return new artx_view_drupal7();
	return new artx_view_drupal56();
}

function get_artisteer_export_version() {
	return 7;
}

if (!function_exists('render'))	{
	function render($var) {
		return $var;
	}
}

class artx_view_drupal56 {
	
	function print_head($vars) {
		foreach (array_keys($vars) as $name)
			$$name = & $vars[$name];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo get_page_language($language); ?>" xml:lang="<?php echo get_page_language($language); ?>" <?php echo get_page_direction($language); ?> >
<head>
  <?php echo $head; ?>
  <title><?php if (isset($head_title )) { echo $head_title; } ?></title>  
  <?php echo $styles ?>
  <?php echo $scripts ?>
  <!--[if IE 6]><link rel="stylesheet" href="<?php echo $base_path . $directory; ?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->  
  <!--[if IE 7]><link rel="stylesheet" href="<?php echo $base_path . $directory; ?>/style.ie7.css" type="text/css" media="screen" /><![endif]-->
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
</head>

<body <?php if (!empty($body_classes)) { echo 'class="'.$body_classes.'"'; } ?>>
<?php
	}


	function print_closure($vars) {
	echo $vars['closure'];
?>
</body>
</html>
<?php
	}

	function print_maintenance_head($vars) {
		foreach (array_keys($vars) as $name)
			$$name = & $vars[$name];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo get_page_language($language); ?>" xml:lang="<?php echo get_page_language($language); ?>" <?php echo get_page_direction($language); ?> >
<head>
  <?php echo $head; ?>
  <title><?php if (isset($head_title )) { echo $head_title; } ?></title>  
  <?php echo $styles ?>
  <?php echo $scripts ?>
  <!--[if IE 6]><link rel="stylesheet" href="<?php echo $base_path . $directory; ?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->  
  <!--[if IE 7]><link rel="stylesheet" href="<?php echo $base_path . $directory; ?>/style.ie7.css" type="text/css" media="screen" /><![endif]-->
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
</head>

<body <?php if (!empty($body_classes)) { echo 'class="'.$body_classes.'"'; } ?>>
<?php
	}
	
	function print_maintenance_closure($vars) {
		echo $vars['closure'];
?>
</body>
</html>
<?php
	}

	function print_comment($vars) {
		foreach (array_keys($vars) as $name)
		$$name = & $vars[$name];
?>
<div class="comment<?php print ($comment->new) ? ' comment-new' : ''; print ' '. $status; print ' '. $zebra; ?>">

  <div class="clear-block">
  <?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
  <?php endif; ?>

  <?php if ($comment->new) : ?>
    <span class="new"><?php print drupal_ucfirst($new) ?></span>
  <?php endif; ?>

  <?php print $picture ?>

    <h3><?php print $title ?></h3>

    <div class="content">
      <?php print $content ?>
      <?php if ($signature): ?>
      <div class="clear-block">
        <div>—</div>
        <?php print $signature ?>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <?php if ($links): ?>
    <div class="links"><?php print $links ?></div>
  <?php endif; ?>
</div>
<?php
	}

	function print_comment_wrapper($vars) {
		foreach (array_keys($vars) as $name)
			$$name = & $vars[$name];
?>
<div id="comments">
  <?php print $content; ?>
</div>
	<?php
	}

	function print_comment_node($vars) {
		return;
	}

	function get_incorrect_version_message() {
		if (get_artisteer_export_version() > 6) {
			return t('This version is not compatible with Drupal 5.x or 6.x and should be replaced.');
		}
		return '';
	}
}


class artx_view_drupal7 {

	function print_head($vars) {
		print render($vars['page']['header']);
	}
	
	function print_closure($vars) {
		return;
	}

	function print_maintenance_head($vars) {
		foreach (array_keys($vars) as $name)
			$$name = & $vars[$name];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>">

<head>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <!--[if IE 6]><link rel="stylesheet" href="<?php echo base_path() . $directory; ?>/style.ie6.css" type="text/css" media="screen" /><![endif]-->  
  <!--[if IE 7]><link rel="stylesheet" href="<?php echo base_path() . $directory; ?>/style.ie7.css" type="text/css" media="screen" /><![endif]-->
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
<?php
	}
	
	function print_maintenance_closure($vars) {
?>
</body>
</html>
<?php
	}

	function print_comment($vars) {
		foreach (array_keys($vars) as $name)
			$$name = & $vars[$name];
?>
<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php print $picture ?>

  <div class="submitted">
    <?php print $permalink; ?>
    <?php
      print t('Submitted by !username on !datetime.',
        array('!username' => $author, '!datetime' => $created));
    ?>
  </div>

  <?php if ($new): ?>
    <span class="new"><?php print $new ?></span>
  <?php endif; ?>

  <?php print render($title_prefix); ?>
  <h3><?php print $title ?></h3>
  <?php print render($title_suffix); ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['links']);
      print render($content);
    ?>
    <?php if ($signature): ?>
    <div class="user-signature clearfix">
      <?php print $signature ?>
    </div>
    <?php endif; ?>
  </div>

  <?php print render($content['links']) ?>
</div>
<?php
	}

	function print_comment_wrapper($vars)	{
		foreach (array_keys($vars) as $name)
			$$name = & $vars[$name];
?>
<div id="comments" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if ($content['comments'] && $node->type != 'forum'): ?>
    <?php print render($title_prefix); ?>
    <h2 class="yellow-postheader"><?php print t('Comments'); ?></h2>
    <?php print render($title_suffix); ?>
  <?php endif; ?>

  <?php print render($content['comments']); ?>

  <?php if ($content['comment_form']): ?>
    <h2 class="yellow-postheader"><?php print t('Add new comment'); ?></h2>
    <?php print render($content['comment_form']); ?>
  <?php endif; ?>
</div>
	<?php
	}

	function print_comment_node($vars) {
		foreach (array_keys($vars) as $name)
			$$name = & $vars[$name];
		$comments = (isset($content['comments']) ? render($content['comments']) : '');
		if (!empty($comments) && $page):
?>
<div class="yellow-box yellow-post">
    <div class="yellow-box-body yellow-post-body">
<div class="yellow-post-inner yellow-article">

<div class="yellow-postcontent">
	
<?php
		echo $comments;
?>

	</div>
	<div class="cleared"></div>
	

</div>

		<div class="cleared"></div>
    </div>
</div>

<?php endif;
	}

	function get_incorrect_version_message() {
		if (get_artisteer_export_version() < get_drupal_major_version()) {
			return t('This version is not compatible with Drupal 7.x. and should be replaced.');
		}
		return '';
	}
}

