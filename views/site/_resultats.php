<?php
use yii\helpers\Html;

// Si g pas de voyage j'arrête là
if (empty($voyages)) {
    return; 
}
?>

<table class="table table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Conducteur</th>
            <th>places proposées</th>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Véhicule</th>
            <th>Prix Total</th>
            <th>Places</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($voyages as $v): ?>
           
            
            <tr>
                <td><?= Html::encode($v->nomConducteur->pseudo ?? 'Inconnu') ?></td>
                <td><?= Html::encode($v->nbplacedispo) ?></td>
                <td><?= Html::encode($v->heuredepart) ?>h</td>
                
                <td><?= Html::encode($v->getHeurreArrive($v->infosTrajet->distance)) ?></td>
                
                <td><?= Html::encode($v->marque->marquev ?? '') ?></td>
                
                <td style="font-weight:bold; color:green;">
                    <?= $v->getCoutTotal($v->infosTrajet->distance, $nb_personnes) ?> €
                </td>
                
                <td>
                    <?php if ($v->getPlacesDisponibles() < $nb_personnes): ?>
                        <span style="color: red; font-weight: bold;">COMPLET</span>
                    <?php else: ?>
                        <span style="color: green;"><?= $v->getPlacesDisponibles() ?> places</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if ($v->getPlacesDisponibles() >= $nb_personnes): ?>
                        <button class="btn btn-primary btn-sm btn-reserver" 
                                data-id="<?= $v->id ?>" 
                                data-nb-personnes="<?= $nb_personnes ?>">
                            Réserver
                        </button>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-sm" disabled>X</button>
                    <?php endif; ?>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>