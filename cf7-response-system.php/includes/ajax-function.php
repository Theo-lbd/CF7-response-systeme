<?php
function get_contact_form_submissions() {
    global $wpdb;
    
    if (!$wpdb) {
        return 'Erreur: $wpdb non disponible.';
    }
    
    $table_name = 'wor4194_db7_forms';
    
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        return 'Erreur: La table n\'existe pas.';
    }
    
    $results = $wpdb->get_results("SELECT * FROM {$table_name}", ARRAY_A);
    
    if (null === $results) {
        return 'Erreur lors de l\'exécution de la requête SQL.';
    }
    
    // Filtrez les soumissions en fonction de l'option
    $responded_submissions = get_option('responded_submissions', array());
    $results = array_filter($results, function($submission) use ($responded_submissions) {
        return !in_array($submission['form_id'], $responded_submissions);
    });

    return $results;
}

function get_responded_contact_form_submissions() {
    global $wpdb;
    
    if (!$wpdb) {
        return 'Erreur: $wpdb non disponible.';
    }
    
    $table_name = 'wor4194_db7_forms';
    
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        return 'Erreur: La table n\'existe pas.';
    }
    
    $results = $wpdb->get_results("SELECT * FROM {$table_name}", ARRAY_A);
    
    if (null === $results) {
        return 'Erreur lors de l\'exécution de la requête SQL.';
    }
    
    // Filtrez les soumissions en fonction de l'option
    $responded_submissions = get_option('responded_submissions', array());
    $results = array_filter($results, function($submission) use ($responded_submissions) {
        return in_array($submission['form_id'], $responded_submissions);
    });

    return $results;
}
