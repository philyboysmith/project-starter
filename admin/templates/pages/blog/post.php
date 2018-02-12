<?php perch_layout('header',[
    'blog-post'=>true
]); ?>

<main class="c-main">
    <?php perch_content('Hero'); ?>

    <div class="l-container l-container--narrow">
		
			<?php
		        perch_blog_post(perch_get('s'));
		    ?>
    </div>
</main>
<?php perch_layout('footer'); ?>

