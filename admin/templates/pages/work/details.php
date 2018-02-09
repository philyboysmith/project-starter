<?php perch_layout('header'); ?>

<main class="c-main">


    <?php perch_collection('clients', [
        'filter'=>'slug',
        'value'=> perch_get('s')
    ]); ?>

    <?php //perch_collection('projects', [
        // 'filter'=>
    //]); ?>

</main>
<?php perch_layout('footer'); ?>