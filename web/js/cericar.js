$(document).ready(function() {

    //NAVIGATION Liens du menu (sans recharger la page)
    $(document).on('click', '.ajax-link', function(e) {
        e.preventDefault();
        $('#contenu-site').load($(this).attr('href'));//Charger le contenu
    });

    //FORMULAIRES - Inscription, Proposer (en AJAX)
    $(document).on('submit', '#contenu-site form', function(e) {
        
        var form = $(this);
        var actionUrl = form.attr('action');
        
        if (form.attr('id') === 'formulaire-recherchex') {
            return; 
        }

        if (actionUrl.indexOf('login') !== -1 || actionUrl.indexOf('logout') !== -1) {
            return;
        }

        e.preventDefault();

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    afficherNotif(response.message || "Opération réussie !");
                    $('#contenu-site').load('index.php?r=site/index');
                } else {
                    $('#contenu-site').html(response);
                }
            },
            error: function() {
                console.log("Erreur AJAX");
            }
        });
    });

    //RECHERCHE DE VOYAGE
    $(document).on('submit', '#formulaire-recherchex', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response, status, xhr) {
                var message = xhr.getResponseHeader('Notification');
                if(message) afficherNotif(message);
                $('#zone-resultats').html(response);
            }
        });
    });

    //RESERVATION
    $(document).on('click', '.btn-reserver', function(e) {
        e.preventDefault();
        
        if (confirm("Confirmer la réservation ?")) {
            var bouton = $(this);            
            $.ajax({
                url: 'index.php?r=site/reserver',
                type: 'POST',
                data: { 
                    id_voyage: bouton.data('id'), 
                    nb_personnes: bouton.attr('data-nb-personnes') || bouton.data('nb-personnes')
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        bouton.removeClass('btn-primary').addClass('btn-success');
                        bouton.text('Réservé !');
                        bouton.prop('disabled', true);
                        afficherNotif(response.message);
                    } else {
                        alert(response.message); 
                    }
                }
            });
        }
    });

    // Fonction pour afficher les messages
    function afficherNotif(msg) {
        $('#flash-notification').removeClass('alert-danger').addClass('alert-success');
        $('#flash-notification').text(msg).show().fadeOut(4000);
    }

});