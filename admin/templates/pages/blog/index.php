<?php perch_layout('header'); ?>

<main class="c-main">
    <?php perch_content('Hero'); ?>

    <div class="l-container l-container--narrow">
			<?php
                perch_blog_custom(array(
                    'count' => 4,
                    'template' => 'post_in_list.html',
                    'sort' => 'postDateTime',
                    'page-links' => 'true',
                    'page-link-style' => 'all',
                ));
            ?>
    </div>
</main>
<?php perch_layout('footer'); ?>