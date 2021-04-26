<?php

// TO DO

get_header(); ?>

<div class="layout"><main id="main" class="main mw mw--txt">

    <h1>Recherche</h1>
       
    <?php 
    global $wp_query;
    $nbResults = $wp_query->found_posts;
    $txtResults = ( $nbResults > 1 ) ? 'résultats' : 'résultat';
    ?>    
    <p class="search-infos"><strong><?= $nbResults; ?></strong> <?= $txtResults; ?> pour <em><?= get_search_query(); ?></em></p>

    <dl class="search-list">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
    $postType = get_post_type();
    ?>

        <dt class="search-title search-title--<?= $postType; ?>"><?php the_title(); ?></dt>
        <dd class="search-resum">xxx</dd>
        <dd class="search-link-box">
            <?php switch ($postType) {
                case 'page':
                    echo '<a class="btn-default search-link" href="'.get_the_permalink().'" title="">Voir l\'article</a>';
                    break;
                case BLOG_POST_SLUG:
                    echo '<a class="btn-default search-link" href="'.get_the_permalink().'" title="">Voir l\'actualité</a>';
                    break;
                case 'product':
                    echo '<a class="btn-default btn-default--red search-link" href="'.get_the_permalink().'" title="">Voir le produit</a>';
                    break;
            } ?>
        </dd>

    <?php endwhile; endif; ?>
    </dl>

    <?php //pc_pager_display(); ?>

</div></main>

<?php get_footer(); ?>