<?php

function create_pdf_category_taxonomy() {
    $labels = array(
        'name' => _x('Catégories PDF', 'taxonomy general name'),
        'singular_name' => _x('Catégorie PDF', 'taxonomy singular name'),
        // Ajoutez d'autres propriétés d'étiquettes au besoin...
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'pdf-category'),
    );

    register_taxonomy('pdf_category', 'attachment', $args);
}

add_action('init', 'create_pdf_category_taxonomy', 0);
