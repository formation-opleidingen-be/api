<?php

//Options de l'API
$options = array( 'location' => 'http://formation.be/api/', 
                  'uri' => 'http://formation.be/' );


//Creez une instance SOAPClient
$training_api = new SoapClient(NULL, $options);

//Préparez votre méthode
$login = 'user@your.mail'; // L'adresse email doit être enregistée sur formation.be ou opleidingen.be et être Administrateurs de l’organisme 
$password = 'your_password'; // Votre mot de passe utilisé sur formation.be ou opleidingen.be

$atts_insert = array(

    'center_id' => 29884, // * ID du centre, vous retrouverez cette info dans votre espace organisme ; attention votre ID est différent sur formation.be (fr) ou opleidingen.be (nl)
    //Votre ID est indiqué dans l'espace réservé organisme, utilisez les chiffre après le #...
    'ref' => 'myref', // * Votre reférence pour cette formation ; cette information n'est pas public, vous l'utiliserez pour mettre à jour vos formations
    'title' => 'My training title 201', // * Le nom de votre formation ; max 80 caractères ; supporte utf8
    'contact_user' => 'user@your.mail', // * L'adresse email doit être enregistée sur formation.be ou opleidingen.be et être Administrateurs de l’organisme 
    'domain' => 'achats-approvisionnement', // * Consultez la liste de nos domaines via la documentation ou utilisez la méthode 'get_domains' (voir plus bas)
    'sub_domain' => 'achats-operationnels', // * Consultez la liste de nos domaines via la documentation ou utilisez la méthode 'get_domains'
    'type' => 'fix', // * peut être: fix, cycle ou custom (à date fixe, cycle complet organisé en modules our Sur-mesure)
    // !!! attention cycle complet, necéssite l'ajout de module, cette option est en cours de développement
    'custom_too' => true, // Cette formation peut aussi se donner sur mesure ou en intra entreprise ; peut être: true ou false ; uniquement si la formation est à date fixe
    'max_entries' => 10, // * Nombre de participants maximum ; exige un nombre entier
    'entrant_profil' => 'text here', // * Profil des participants
    'entrant_require' => 'text here', // * Niveau d'admission/prérequis
    'certification' => 'Médaille', // * Titre délivré pour cette formation; choix: none, dip, cert ou att; champ texte libre ex: Médaille
    //none = Aucun
    //dip = Diplôme
    //cert = Certificat
    //att = Attestation
    'training_lang' => 'fr', // * Choix: fr, nl ou en; champ texte libre ex: Danish
    'goals' => 'text here', // * Objectifs de la formation ; champ texte libre
    'desc' => 'text here', // * Description de la formation ; champ texte libre
    'subvention' => '', // Subsides et interventions possibles ; champ texte libre

    /*
    Prix & conditions
    ne s'applique pas aux formations sur-mesures
    */
    'price' => 100, // * Prix ; nombre entier
    'vat_include' => false, // * true ou false; true = TTC & false = HTVA
    'pay_rule' => 1, // * Délai de paiement ; choix(entier) ou texte libre
    //1 = La formation est à payer dans les ... jours qui suivent l’envoi de la facture
    //2 = La formation est à payer au + tard dans les ... jours de la formation
    //3 = La formation est à payer avant le début de la formation
    'pay_rule_days' => 15, // * Délai de paiement en jours; si 'pay_rule' = 1 ou 2 ; nombre entier
    'cancel_rule' => 1, // Délai d'annulation sans pénalités et sans indication de motif ; choix(entier) ou texte libre
    //1 = Jusqu’à ... jours calendrier avant le démarrage de la formation
    //2 = Dans les ... jours ouvrables de l’acceptation du dossier d’inscription
    'cancel_rule_days' => 15, // * Délai d'annulation en jours
    'terms_of_sales' => '', // Conditions générales de vente ; file url (pdf, png, jpg, jpeg)
    'Guaranteed' => true, // * Garantie de prestation

    /*
    Calendrier & réductions
    ne s'applique pas aux formations sur-mesures
    */
    'duration_type' => 'days', // * Durée de la formation exprimée en ; choix: days, months, weeks ou years
    'duration' => 15, // * Durée
    'cycle_more' => '', // Quand se déroule ce cycle complet ? ; texte libre ; uniquement cycle
    'group_discount' => true, // Octroyez-vous une réduction de groupe pour cette formation ? ; true ou false
    'group_discount_rules' => array( //Réduction groupe
        0 => array(
            'entries' => 3, // Nombre de participants ; nombre entier
            'percent' => 5, // Pourcentage pour ce nombre de participants ; nombre entier
            ),
        1 => array(
            'entries' => 6, // Nombre de participants ; nombre entier
            'percent' => 10, // Pourcentage pour ce nombre de participants ; nombre entier
            )
        ),
    'calendar' => array(
        0 => array(
            //exemple pour un cycle; une date de départ et de fin les autres paramètres seront ignorés
            'start_date' => '20170301', //Date de début ; format: Ymd
            'stop_date' => '20171231', //Date de fin ; format: Ymd
            ),
        1 => array(
            'start_date' => '20170301', // Date de début ; format: Ymd
            'stop_date' => '20171231', // Date de fin ; format: Ymd
            'start_h' => 8, // heure de départ ; 24h
            'start_m' => 30, // minute de départ
            'end_h' => 17, // heure de fin ; 24h
            'end_m' => 0, // minute de fin
            'is_lastminute' => true, // Souhaitez-vous mettre en vente des places à prix réduit pour cette formation dans les offres Last Minutes? ; true ou false
            'last_entries' => 5, // Nombre de places Last minute ; nombre entier
            'last_availability' => '24', // Publication automatique de ces places Last minute (nbr jours avant la date de début) ; choix: 24, 15 ou 7
            'last_discount' => 15, // Quel % de réduction souhaitez-vous appliquer ? ; nombre entier ; Min. 5% | Max. 50%
            )
        ),

    /* 
    Lieu 
    */
    'has_location' => true, // true ou false ; false uniquement si sur-mesure
    'address' => '85 Rue de la Nation', // Lieu et adresse ou se donne la formation ; ajouter le code postal dans l'adresse si autre que Belgique
    'country' => 'belgium', // Pays ; choix: belgium, france, luxembourg, netherlands ou swiss
    'be_zip_code' => '1000', // Code postal ; uniquement si Belgique

    /*
    Extensions
    Rendez votre contenu plus attractif avec les extensions. Ajouter des images, des vidéo et du texte.
    */
    'extensions' => array(
        0 => array(
            'type' => 1, // Titre + paragraphe
            'title' => 'text here',
            'content' => 'text here'
            ),
        1 => array(
            'type' => 2, // Vidéo
            'from' => 'youtube', // choix: youtube, vimeo ou daylimotion 
            'url' => 'https://www.youtube.com/watch?v=Bms33Rjj6iY', // Lien complet
            ),
        2 => array(
            'type' => 3, // Fichiers téléchargés
            'files' => array(
                0 => 'http://greaty.be/cgv-greaty.pdf'
                )
            ),
        3 => array(
            'type' => 4, // Photo/Image
            'url' => 'http://www.greaty.be/wp-content/uploads/2016/09/Bus-Stop-Billboard-969x650.png'
            ),
        4 => array(
            'type' => 5, // Galerie
            'images' => array(
                0 => 'http://www.greaty.be/wp-content/uploads/2016/09/Bus-Stop-Billboard-969x650.png',
                1 => 'http://www.greaty.be/wp-content/uploads/2016/09/nocturnes-2016-magazine-969x650.jpg',
                2 => 'http://www.greaty.be/wp-content/uploads/2016/09/illustration1-969x650.jpg',
                //...
                )
            ),
        )
    );



/**
Inserer une formation
Encodez vos attributs en JSON
return: JSON
**/
//echo $training_api->insert_training( $login, $password, json_encode( $atts_insert ) );

/**
liste des domaines et thématique fr ou nl
return: JSON
**/
//echo $training_api->get_domains('fr');
//echo $training_api->get_domains('nl');

/**
Mettre à jour une formation
center_id et ref sont obligatoires
return: JSON
**/
$atts_update = array( 
    'center_id' => 29884, // * ID du centre, vous retrouverez cette info dans votre espace organisme ; attention votre ID est différent sur formation.be (fr) ou opleidingen.be (nl)
    'ref' => 'myref', // * Votre reférence pour cette formation ; cette information n'est pas public, vous l'utiliserez pour mettre à jour vos formations
    'title' => 'My training title 202', // Le nom de votre formation ; max 80 caractères ; supporte utf8
    );
//echo $training_api->update_training( $login, $password, json_encode( $atts_update ) );

/**
Effacer une formation
center_id et ref sont obligatoires
La fonction n'efface qu'une formation à la fois, si par erreur vous avez encoder plusieurs fois la même référence vous devrez relancer la fonction.
return: JSON
**/
$atts_delete = array( 
    'center_id' => 29884, // * ID du centre, vous retrouverez cette info dans votre espace organisme ; attention votre ID est différent sur formation.be (fr) ou opleidingen.be (nl)
    'ref' => 'myref', // * Votre reférence pour cette formation ; cette information n'est pas public, vous l'utiliserez pour mettre à jour vos formations
    );
//echo $training_api->delete_training( $login, $password, json_encode( $atts_delete ) );


/**
A venir
- ajouter un module à un cycle complet
- Aperçu pour les extensions 3, 4 & 5
**/
?>