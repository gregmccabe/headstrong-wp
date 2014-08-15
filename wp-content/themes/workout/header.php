<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Favicons -->
	<link rel="shortcut icon" href="<?php echo get_theme_mod('t2t_customizer_favicon'); ?>" />
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon-114x114.png">

	<?php wp_head(); ?>

	<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" href="<?php get_template_directory_uri(); ?>/stylesheets/ie8.css" />
	<![endif]-->
</head>
<body <?php body_class(); ?>>

	<header class="<?php echo t2t_header_layout(); ?>">
		<div class="wrapper">
			<div class="container">
				<div class="logo">
					<?php if ( get_theme_mod('t2t_customizer_logo') ) { ?>
						<a href="<?php echo home_url(); ?>">
							<?php if(get_theme_mod('t2t_customizer_retina_logo')) { ?>
								<img src="" data-src="<?php echo get_theme_mod('t2t_customizer_logo'); ?>" data-ret="<?php echo get_theme_mod('t2t_customizer_retina_logo'); ?>" alt="<?php the_title(); ?>" class="logo-retina" />
							<?php } else { ?>
								<img src="<?php echo get_theme_mod('t2t_customizer_logo'); ?>" alt="<?php the_title(); ?>" />
							<?php } ?>
						</a>
					<?php } else { ?>
						<a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
					<?php } ?>
				</div>

				<nav>
					<?php
						if(has_nav_menu('primary-menu' )) {
							wp_nav_menu(
								array(
									'container'      => '',
									'menu_class'     => 'main-menu',
									'theme_location' => 'primary-menu'
								)
							);
						} else {
							echo '<div class="notice">Please setup a "Main Menu" in <a href="'. admin_url('nav-menus.php') .'"><b>Wordpress Dashboard</b> > <b>Appearance</b> > <b>Menus</b></a></div>';
						}
					?>
				</nav>
				<div class="clear"></div>
			</div>
		</div>
	</header>

	<?php if(!is_page_template("template-home.php")) { ?>
	<div id="page_title">
		<div class="container">
	  	<span class="title">
	  		<?php
	  			// If is a single post page
	  			if(is_single()) {
	  				echo get_the_title();
	  			}
	  			elseif(function_exists('is_product') && is_product()) {
	  				echo get_the_title();
	  			}
	  			// If frontpage is not set
	  			elseif(is_front_page() && get_option('page_for_posts', true) == 0 || get_post_type(get_the_ID()) == "post" && is_single()) {
	  				echo __('Blog', 'framework');
	  			}
	  			elseif(is_attachment()) {
	  				echo get_the_title($post->post_parent);
	  			}
	  			// Is woocommerce
	  			elseif(function_exists('is_shop') && is_shop() && get_option('woocommerce_shop_page_id')) {
	  				echo get_the_title(get_option('woocommerce_shop_page_id'));
	  			}
				// Is tag
				elseif(is_tag()) {
					echo single_tag_title(__("Tag: ", "framework"));
				}
				// Is category
				elseif(is_category()) {
					echo single_cat_title(__("Category: ", "framework"));
				}
				// Is tag
				elseif(function_exists('is_product_tag') && is_product_tag()) {
					echo single_tag_title(__("Product Tag: ", "framework"));
				}
				// Is category
				elseif(function_exists('is_product_category') && is_product_category()) {
					echo single_cat_title(__("Product Category: ", "framework"));
				}
				elseif(function_exists('is_cart') && is_cart()) {
					echo __("Cart", "framework");
				}
				elseif(function_exists('is_checkout') && is_checkout()) {
					echo __("Checkout", "framework");
				}
				elseif(function_exists('is_account_page') && is_account_page()) {
					echo __("Account", "framework");
				}
	  			// Is page
	  			elseif(get_option('page_for_posts', true) == get_queried_object_id()) {
	  				echo get_the_title(get_option('page_for_posts', true));
	  			}
	  			else {
	  				echo get_the_title();
	  			}
	  		?>
	  	</span>

  		<?php
  			// If is a single post page
  			if(is_single()) {
  				if(in_array(get_post_format(get_queried_object_id()), array("post", "aside"))) {
	  				$subtitle_text = date(get_option("date_format"), strtotime(get_the_date()));
  				}
  			}
  			elseif(function_exists('is_shop') && is_shop() && get_option('woocommerce_shop_page_id')) {
  				$subtitle_text = get_post_meta(get_option('woocommerce_shop_page_id'), "subtitle", true);
  			} else {
  				$subtitle_text = get_post_meta(get_queried_object_id(), "subtitle", true);
  			}
  		?>

  		<?php if(isset($subtitle_text) && $subtitle_text != "") : ?>
	  	<span class="sub_title">
	  		<?php echo $subtitle_text; ?>
	  	</span>
		<?php endif; ?>
	  </div>
	</div>
	<?php } ?>