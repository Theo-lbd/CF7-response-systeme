<?php
function afficher_factures() {
     // Récupérer les fichiers PDF téléchargés dans la catégorie "Facture"
     $args = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'application/pdf',
        'posts_per_page' => -1,
        'tax_query' => array(
        array(
            'taxonomy' => 'pdf_category',
            'field' => 'slug',
            'terms' => 'facture', // Remplacez "facture" par le slug de votre catégorie "Facture"
        ),
    ),
    );
    $attachments = get_posts($args);

    ob_start(); // Commence la capture de la sortie

    ?>

    <?php if ($attachments) : ?>
        <table>
            <thead  class="thead">
                <tr>
                    <th>N° / Date de facture</th>
                    <th>Télécharger ma facture</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attachments as $attachment) : ?>
                    <tr>
                        <td><?php echo get_the_title($attachment->ID); ?></td>
                        <td><a href="<?php echo wp_get_attachment_url($attachment->ID); ?>" target="_blank">Télécharger</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
    <p>Aucun fichier PDF trouvé dans la catégorie "Facture".</p>
    <?php endif; ?>

    <?php
    return ob_get_clean(); // Renvoie la sortie capturée et termine la capture
}

add_shortcode('afficher_factures', 'afficher_factures');
