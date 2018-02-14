<?php $item = perch_collection('clients', [
        'filter'=>'slug',
        'value'=> perch_get('s'),
        'skip-template'=>true
], false); 

perch_layout('header', [
    'title'=>$item[0]['title']
]); ?>

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