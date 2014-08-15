<?php if (have_comments()) : ?>
	<!-- Start Comments -->
	<div id="comments">

	<ol class="commentlist">
		<?php wp_list_comments(array('avatar_size' => 120 )); ?>
	</ol>

	<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
		<div class="pagination">
			<a href=""><?php previous_comments_link('&#x2190; Previous') ?></a>
			<span>|</span>
			<a href=""><?php next_comments_link('Next &#x2192;') ?></a>
		</div>
	<?php endif; ?>

	</div>
	<!-- End Comments -->

<?php endif; ?>

<?php comment_form( array('title_reply' => __('Leave a reply', 'framework'), 'comment_notes_after'  => '')); ?>