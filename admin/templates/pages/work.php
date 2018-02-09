<?php perch_layout('header'); ?>

<main class="c-main">
    <?php perch_content('Hero'); ?>
    <div class="l-container  l-container--flex">
        <div class="l-subnav">
            <?php perch_categories('service'); ?>
        </div>
        <div class="l-main">
            <div class="c-work">
                <?php $categories = perch_categories([
                    'set' => 'service',
                    'skip-template'=> true,
                    'raw' => true
                ], true); 
                
                foreach ($categories as $key => $category) {?>

                <div id="<?php echo $category['catSlug']; ?>-work" class="c-work__item  c-work__item--film" <?php if($key == 0) echo 'style="display:block;"';?>>
                    <div class="c-work__description">
                        <h2><?php echo $category['catTitle']; ?></h2>
                        <?php echo $category['desc']; ?>

                        <?php perch_collection('projects', [
                            'category' => $category['catPath'],
                        ]); ?>
                    </div>
                </div>


                <?php } ?>
                
            </div>
        </div>
    </div>

</main>
<?php perch_layout('footer'); ?>