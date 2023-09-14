<?php
function display_contact_form_submissions_shortcode($atts) {
    ob_start();
    $submissions = get_contact_form_submissions();

    if (!empty($submissions)) {
        // Début du tableau
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>Nom</th>';
        echo '<th>Prénom</th>';
        echo '<th>Intérêt</th>';
        echo '<th>Message</th>';
        echo '<th>Répondre</th>';
        echo '</tr>';

        // Lignes du tableau
        foreach ($submissions as $submission) {
            $form_data = unserialize($submission['form_value']);

            echo '<tr>';
            echo '<td>' . (isset($form_data['your-name']) ? $form_data['your-name'] : '') . '</td>';
            echo '<td>' . (isset($form_data['your-lastname']) ? $form_data['your-lastname'] : '') . '</td>';
echo '<td>' . (isset($form_data['your-interest']) && is_array($form_data['your-interest']) && !empty($form_data['your-interest']) ? $form_data['your-interest'][0] : '') . '</td>';
            echo '<td>' . (isset($form_data['your-message']) ? $form_data['your-message'] : '') . '</td>';
            echo '<td><a href="https://a3plusclimatisation.fr/test-reponse-form/?form_id=' . $submission['form_id'] . '">Répondre</a></td>';
            echo '</tr>';
        }

        // Fin du tableau
        echo '</table>';
    } else {
        echo 'Aucun nouveau message.';
    }

    return ob_get_clean();
}

function response_form_shortcode($atts) {
    ob_start();
    $form_id = isset($_GET['form_id']) ? intval($_GET['form_id']) : '';
    ?>
    <div id="response-form-container">
    <form method="post" action="" id="response-form">
        <input type="hidden" name="form_id" value="<?php echo esc_attr($form_id); ?>">
        <textarea name="response"></textarea>
        <input type="submit" value="Envoyer la réponse">
    </form>
    <div id="success-message" style="display: none;">
        Votre message a été envoyé avec succès.
    </div>
</div>

    <?php
    return ob_get_clean();
}

function display_responded_contact_form_submissions_shortcode($atts) {
    ob_start();
    $submissions = get_responded_contact_form_submissions();

    if (!empty($submissions)) {
        // Début du tableau
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>Nom</th>';
        echo '<th>Email</th>';
        echo '<th>Objet</th>';
        echo '<th>Message</th>';
        echo '</tr>';

        // Lignes du tableau
        foreach ($submissions as $submission) {
            $form_data = unserialize($submission['form_value']);

            echo '<tr>';
            echo '<td>' . (isset($form_data['your-name']) ? $form_data['your-name'] : '') . '</td>';
            echo '<td>' . (isset($form_data['your-email']) ? $form_data['your-email'] : '') . '</td>';
            echo '<td>' . (isset($form_data['your-subject']) ? $form_data['your-subject'] : '') . '</td>';
            echo '<td>' . (isset($form_data['your-message']) ? $form_data['your-message'] : '') . '</td>';
            echo '</tr>';
        }

        // Fin du tableau
        echo '</table>';
    } else {
		echo 'Aucun message archivé.';
    }

    return ob_get_clean();
}

add_shortcode('display_contact_submissions', 'display_contact_form_submissions_shortcode'); 
add_shortcode('response-form', 'response_form_shortcode');
add_shortcode('display_responded_contact_submissions', 'display_responded_contact_form_submissions_shortcode');
