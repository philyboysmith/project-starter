<?php perch_layout('header', [
    'body-class'=>'fixed-header'
]); ?>

<main class="c-main">
    <?php perch_content('Hero'); ?>

    <?php perch_collection('projects', [
    ]); ?>
</main>
<?php perch_layout('footer'); ?>