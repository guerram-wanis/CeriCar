<?php
use yii\helpers\Html;

$this->title = 'Mon Profil';
?>
<div class="site-profil container">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row mt-4">
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Mes Informations
                </div>
                <div class="card-body">
                    <p><strong>Pseudo :</strong> <?= Html::encode($user->pseudo) ?></p>
                    
                    <p><strong>Nom :</strong> <?= Html::encode($user->nom) ?></p>
                    <p><strong>Prénom :</strong> <?= Html::encode($user->prenom) ?></p>
                    <p><strong>Email :</strong> <?= Html::encode($user->mail) ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!--Section Réservations effectuées -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Mes Réservations</h4>
                </div>
                <div class="card-body">
                    <?php if (empty($reservations)): ?>
                        <div class="alert alert-warning">
                            Vous n'avez effectué aucune réservation pour le moment.
                        </div>
                    <?php else: ?>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Trajet</th>
                                    <th>Heure de départ</th>
                                    <th>Places réservées</th>
                                    <th>État</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reservations as $resa): ?>
                                    <tr>
                                        <td>
                                            <?php 
                                            if ($resa->infosVoyage && $resa->infosVoyage->infosTrajet) {                                        
                                                $trajet = $resa->infosVoyage->infosTrajet;                                        
                                                echo Html::encode($trajet->depart . ' -> ' . $trajet->arrivee);
                                            } else {
                                                echo 'Voyage #' . $resa->voyage;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if ($resa->infosVoyage) {
                                                echo Html::encode($resa->infosVoyage->heuredepart) . 'h00';
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td><?= $resa->nbplaceresa ?> places</td>
                                        <td>
                                            <span class="badge bg-success">Confirmé</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Section Voyages proposés -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Mes Voyages Proposés</h4>
                </div>
                <div class="card-body">
                    <?php if (empty($voyagesProposes)): ?>
                        <div class="alert alert-warning">
                            Vous n'avez proposé aucun voyage pour le moment.
                        </div>
                    <?php else: ?>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Trajet</th>
                                    <th>Heure de départ</th>
                                    <th>Places disponibles</th>
                                    <th>Places réservées</th>
                                    <th>Tarif</th>
                                    <th>État</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($voyagesProposes as $voyage): ?>
                                    <tr>
                                        <td>
                                            <?php 
                                            if ($voyage->infosTrajet) {
                                                $trajet = $voyage->infosTrajet;
                                                echo Html::encode($trajet->depart . ' -> ' . $trajet->arrivee);
                                            } else {
                                                echo 'Voyage #' . $voyage->id;
                                            }
                                            ?>
                                        </td>
                                        <td><?= Html::encode($voyage->heuredepart) ?>h00</td>
                                        <td><?= Html::encode($voyage->nbplacedispo) ?> places</td>
                                        <td>
                                            <?= $voyage->getNbPlacesReservees() ?>
                                        </td>
                                        <td><?=  $voyage->getCoutTotal($voyage->infosTrajet->distance, 1) ?> €/km</td>
                                        <td>
                                            <?php if ($voyage->estComplet()): ?>
                                                <span class="badge bg-danger">Complet</span>
                                            <?php else: ?>
                                                <span class="badge bg-primary">Disponible</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>