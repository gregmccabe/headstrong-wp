<?php get_header(); ?>

<?php

  //Get Cart URL
  global $woocommerce;

  $cart_url = $woocommerce->cart->get_cart_url();
  $cart_count = $woocommerce->cart->get_cart_contents_count();
  $checkout_url = $woocommerce->cart->get_checkout_url();

?>
<?php get_header(); ?>
<section id="content" class="shop">
  <div class="<?php echo get_post_meta(get_queried_object_id(), 'layout', true); ?> container">
      <div class="page_content">
        <?php woocommerce_content(); ?>
      </div>

    <div class="clear"></div>
  </div>
</section>
<?php get_footer(); ?>