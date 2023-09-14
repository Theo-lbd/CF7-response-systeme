<?php
/*
Plugin Name: CF7 Response System
Description: Un système de réponse et d'affichage pour les soumissions de formulaires Contact Form 7.
Version: 1.0
Author: Théo labadie
*/

// Inclure les fichiers avec les fonctions nécessaires
require plugin_dir_path( __FILE__ ) . 'includes/shortcode-functions.php';
require plugin_dir_path( __FILE__ ) . 'includes/ajax-functions.php';

// Enregistrer le script JS
function enqueue_response_form_script() {
    wp_enqueue_script(
        'response-form',
        plugins_url('js/response-form.js', __FILE__),
        array('jquery'),
        '1.0.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'enqueue_response_form_script');

function handle_contact_form_response() {
    global $wpdb;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_id']) && isset($_POST['response'])) {
        $form_id = intval($_POST['form_id']);
        $response = sanitize_textarea_field($_POST['response']);

        $submission = $wpdb->get_row($wpdb->prepare("SELECT * FROM wor4194_db7_forms WHERE form_id = %d", $form_id));

        if ($submission) {
            $form_data = unserialize($submission->form_value);
            $recipient_email = isset($form_data['your-email']) ? sanitize_email($form_data['your-email']) : '';

            if (filter_var($recipient_email, FILTER_VALIDATE_EMAIL) && !empty($response)) {
                $subject = 'Réponse à votre soumission';
                $headers = array(
                    'From: A3 plus climatisation <RENTRER VOTRE ADRESSE EMAIL>',
                    'Reply-To: RENTRER VOTRE ADRESSE EMAIL',
                    'X-Mailer: PHP/' . phpversion()
                );

                // Stockez l'identifiant de la soumission dans une option WordPress avant d'envoyer l'email
                

                if (wp_mail($recipient_email, $subject, $response, $headers)) {
					    error_log("Adding form ID {$form_id} to responded submissions.");
					$responded_submissions = get_option('responded_submissions', array());
                	$responded_submissions[] = $form_id;
                	update_option('responded_submissions', $responded_submissions);
                    echo '<div>Votre réponse a été envoyée avec succès.</div>';
                    echo '<script>
                            setTimeout(function() {
                                window.location.href = "https://www.exemple.fr";  
                            }, 2000);
                          </script>'; // Remplacez par l'URL de votre choix
                }
                
            }
        }
    }
}

add_action('init', 'handle_contact_form_response');
