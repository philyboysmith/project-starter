<?php perch_layout('header', [
    'body-class'=>'fixed-header'
]); ?>

<main class="c-main">
    <?php perch_content('Hero'); ?>
    <div class="l-container l-container--narrow">
        <div class="c-text-block">
            <?php perch_content('Main Content'); ?>
        </div>
    </div>
</main>
<?php perch_layout('footer'); ?>