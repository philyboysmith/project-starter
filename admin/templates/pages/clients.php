<?php perch_layout('header'); ?>

<main class="c-main">
    <?php perch_content('Hero'); ?>
    <div class="l-container l-container--narrow">
        <div class="c-text-block">
            <?php perch_content('Main Content'); ?>
        </div>
    </div>
    <div class="l-container">
        <div class="l-grid  l-grid--v-center">
        <?php $clients = perch_collection('clients', [
            'skip-template'=>true,
            'filter'=>'image',
            'match'=>'neq',
            'value'=>''
        ], true); 

        foreach ($clients as $client){ ?>

            <div class="l-grid__item  l-grid__item--narrow">
                <a href="work/<?php echo $client['slug']; ?>">
                    <img class="c-client__logo" src="<?php echo $client['image']; ?>" alt="<?php echo $client['title']; ?>"/>
                </a>
            </div>

        <?php } ?>
        </div>
        
    </div>
</main>
<?php perch_layout('footer'); ?>