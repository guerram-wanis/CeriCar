<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <?= Html::cssFile('@web/css/site1.css') ?>

</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
        'brandLabel' => 'CeriCar', 
        'brandUrl' => null,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-grey fixed-top']
    ]);

    $menuItems = [
        [
            'label' => 'Rechercher un voage', 
            'url' => ['/site/index'],
            'linkOptions' => ['class' => 'ajax-link']
        ],
    ];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = [
            'label' => 'Inscription', 
            'url' => ['/site/inscription'],
            'linkOptions' => ['class' => 'ajax-link']
        ];
        $menuItems[] = [
            'label' => 'Connexion', 
            'url' => ['/site/login'],
            'linkOptions' => ['class' => 'ajax-link']
        ];
    } else {

        if (!empty(Yii::$app->user->identity->permis)) {
        // S'il a le permis, on affiche le bouton Proposer
        $menuItems[] = ['label' => 'Proposer un trajet', 'url' => ['/site/proposer'], 'linkOptions' => ['class' => 'ajax-link']];
    }
        $menuItems[] = [
            'label' => 'Proposer un trajet', 
            'url' => ['/site/proposer'],
            'linkOptions' => ['class' => 'ajax-link']
        ];    
        $menuItems[] = [
            'label' => 'Mon Profil', 
            'url' => ['/site/profil'],
            'linkOptions' => ['class' => 'ajax-link']
        ];

        $menuItems[] = '<li class="nav-item">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
                'Déconnexion (' . Yii::$app->user->identity->nom . ')', 
                ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto', 'id' => 'menu-principal'], 
        'items' => $menuItems,
    ]);

    NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container" style="padding: 8rem 0 0 0;">

            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>

            <?= Alert::widget() ?>

            <div class="body-content">
                <div id="flash-notification" class="alert alert-info" style="display:none; text-align: center; font-weight: bold; margin-bottom: 20px;"></div>
                
                <div id="contenu-site">
                    <?= $content ?>
                </div>
                </div>

        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy;guerram wanis<?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>