<?php perch_layout('header', [
    'body-class'=>'fixed-header'
]); ?>

<main class="c-main">
    <?php perch_content('Hero'); ?>

    <div class="c-client">

    <?php perch_collection('projects', [
        'filter'=>'featured',
        'template'=>'projects_with_video',
        'value'=>1
    ]); ?>
        </div>

</main>
<?php perch_layout('footer'); ?>