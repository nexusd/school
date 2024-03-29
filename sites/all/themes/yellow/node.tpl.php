<?php 
	$vars = get_defined_vars();
	$view = get_artx_drupal_view();

	$message = $view->get_incorrect_version_message();
	if (!empty($message)) {
		print $message;
		die();
	}
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
<div class="yellow-box yellow-post">
    <div class="yellow-box-body yellow-post-body">
<div class="yellow-post-inner yellow-article">
<h2 class="yellow-postheader"<?php print $title_attributes; ?>><?php print render($title_prefix); ?>
<?php echo art_node_title_output($title, $node_url, $page); ?>
<?php print render($title_suffix); ?>
</h2>
<?php if ($display_submitted): ?>
<div class="yellow-postheadericons yellow-metadata-icons">
<?php echo art_submitted_worker($date, $name); ?>

</div>
<?php endif; ?>
<div class="yellow-postcontent">
<?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      $terms = get_terms_D7($content);
      hide($content[$terms['#field_name']]);
      print render($content);
    ?>

</div>
<div class="cleared"></div>
<?php print $user_picture; ?>
<?php $access_links = true;
if (isset($content['links']['#access'])) {
	$access_links = $content['links']['#access'];
}
if ($access_links && (isset($content['links']) || isset($content['comments']))):
$output = art_links_woker_D7($content);
if (!empty($output)):	?>
<div class="yellow-postfootericons yellow-metadata-icons">
<?php echo $output; ?>

</div>
<?php endif; endif; ?>

</div>

		<div class="cleared"></div>
    </div>
</div>

<?php
	$view->print_comment_node($vars);
?>
</div>