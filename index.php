<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<?php 
if (have_posts())
{
	the_post();
}
$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$last_page = $wp_query->max_num_pages;

if (is_page())
{
	$menu = array_fill(0, 22, null);

	// Obtains a list with all categories:
	$categories = get_categories(array());
	$n = 0;
	foreach($categories as $category)
	{
		$menu[$n] = new stdClass();
		$menu[$n]->name = $category->name;
		$menu[$n]->type = 1;
		$menu[$n]->url = get_category_link($category->cat_ID);
		$n++;
	}
	
	// Obtains a list with menu entries:
	$menuItems = wp_get_nav_menu_items( 'Main Navigation', array()); 
	if ($menuItems)
	{
		$n=27;
		foreach($menuItems as $menuItem)
		{
			$menu[$n] = new stdClass();
			$menu[$n]->name = $menuItem->title;
			$menu[$n]->type = 2;
			$menu[$n]->url = $menuItem->url;
			$n--;
		}
	}
}
?>
	<head>
		<title><?php bloginfo(); ?></title>
		<meta name="robots" content="index, follow" />
		<?php wp_head(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
	</head>
	<body>
		<div class="popup-attachment">
			<img src="" />
		</div>		
		<header class="logo"><a href="/"><i class="fa fa-reorder"></i> <?php bloginfo(); ?> <em><?php bloginfo('description'); ?></em></a></header>
		<div class="content">
			<section class="information">
				<h2><?php the_category(' '); ?></h2>
			</section>
			<?php 
			if (is_page())
			{
				?>
				<section class="menu">
					<ul class="a">
						<?php 
						for($n = 0; $n < 14; $n++)
						{
							if (array_key_exists($n, $menu) && $menu[$n])
							{
								?>
								<li><a rel="preview-<?php echo $n; ?>" href="<?php echo $menu[$n]->url; ?>"><?php echo $menu[$n]->name; ?></a></li>
								<?php 
							}
							else
							{
								?>
								<li class="empty"></li>
								<?php 
							}
						}
						?>
					</ul>
					<ul class="b">
						<?php 
						for($n = 14; $n < 28; $n++)
						{
							if (array_key_exists($n, $menu) && $menu[$n])
							{
								?>
								<li><a rel="preview-<?php echo $n; ?>" href="<?php echo $menu[$n]->url; ?>"><?php echo $menu[$n]->name; ?></a></li>
								<?php 
							}
							else
							{
								?>
								<li class="empty"></li>
								<?php 
							}
						}
						?>
					</ul>
				</section>
				<section class="preview scrollable">
					<?php the_content(); ?>
				</section>
				<?php 
			}
			else
			{
				?>
				<section class="main">
					<?php the_content(); ?>
				</section>
				<?php 
			}
			?>
		</div>
		<?php if (show_posts_nav()):?>
		<nav class="pagination">
			<ul>
				<li class="prev"><?php echo get_previous_posts_link('<i class="fa fa-long-arrow-left"></i>'); ?></li>
				<li class="curr"><?php echo $current_page.') '.$last_page;?></li>
				<li class="next"><?php echo get_next_posts_link('<i class="fa fa-long-arrow-right"></i>'); ?></li>
			</ul>
		</nav>
		<?php endif;?>
	</body>
</html>
