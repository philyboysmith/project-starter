<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/dist/css/styles.css?v=4">
        <?php
            if (perch_layout_has('blog-post')) {
                perch_blog_post_meta(perch_get('s'));
            }elseif (perch_layout_has('title')){
                echo '<title>' . perch_layout_var('title', true) . ' | Purple Door Media</title>';
            }else {
                echo '<title>' . perch_pages_title(true) . ' | Purple Door Media</title>';
            }
        ?>
        <style>
            .l-video-container {
                cursor: pointer;
            }
        </style>
	<?php perch_page_attributes(); ?>
</head>
<body class="<?php perch_layout_var('body-class'); ?>">
  <div style="height: 0; width: 0; position: absolute; visibility: hidden">
    <?php perch_layout('icons'); ?>
  </div>

  <div id="page">
      <header class="c-header__wrapper">
        <div class="l-container">
            <div class="c-header">
                <div class="c-header__logo">
                    <svg viewBox="0 0 258 56" style="width: 258px; height: 56px;">
                        <use xlink:href="#logo"></use>
                    </svg>
                </div>
                <?php perch_pages_navigation([
                    'levels'=> 1
                ]); ?>
                <div class="c-menu-toggle" id="menuToggle">
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                </div>
            </div>
        </div>
    </header>
