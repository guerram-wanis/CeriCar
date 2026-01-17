<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\internaute;
use app\models\trajet;
use app\models\voyage;
use app\models\reservation;
use yii\helpers\Html;
use yii\bootstrap5\Nav;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    // Accueil et Recherche
    public function actionIndex()
    {
        $villeDepart   = Yii::$app->request->post('ville_depart');
        $villeArrivee  = Yii::$app->request->post('ville_arrivee');
        $nb_personnes  = (int) Yii::$app->request->post('nb_personnes');

        $trajet = null;
        $tousLesVoyages = [];

        if ($villeDepart && $villeArrivee) {
            $trajet = trajet::getTrajet($villeDepart, $villeArrivee);
            if ($trajet) {
                $tousLesVoyages = voyage::getVoyageByTrajetId($trajet->id);
            }
        }

        // Cas AJAX : Résultat de recherche
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $voyagesFiltres = [];
            $vehiculeAssezGrand = false;

            foreach ($tousLesVoyages as $v) {
                if ($nb_personnes <= $v->getPlacesMax()) {
                    $vehiculeAssezGrand = true;
                    $voyagesFiltres[] = $v;
                }
            }

            if (!$trajet) {
                $msg = "Recherche terminee : trajet inexistant.";
            } elseif (!$vehiculeAssezGrand && !empty($tousLesVoyages)) {
                $msg = "Aucun véhicule pour {$nb_personnes} personnes.";
            } elseif (empty($voyagesFiltres)) {
                $msg = "Aucun voyage disponible.";
            } else {
                $msg = "Voyage(s) trouve(s).";
            }

            Yii::$app->response->headers->set('Notification', $msg);

            return $this->renderPartial('_resultats', [
                'voyages'      => $voyagesFiltres,
                'nb_personnes' => $nb_personnes,
            ]);
        }

        // Cas AJAX : Navigation menu
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index');
        }

        return $this->render('index');
    }

    public function actionInscription()
    {
        $model = new internaute();
        //je verifie si l'utilisateur a envoyé des données
        if ($model->load(Yii::$app->request->post())) {
            $model->pass = sha1($model->pass);
            //enregistrement dans la BDD
            if ($model->save()) {
                if (Yii::$app->request->isAjax) {
                    return $this->asJson([
                        'success' => true, 
                        'message' => 'Compte créé ! Vous pouvez vous connecter.'
                    ]);
                }
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('inscription', ['model' => $model]);
        }
    }

    public function actionLogin()
    { 
        //l'objet qui recoit le pseudo et le mdp que l'utilisateur va taper
        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                return $this->goBack();
            }
        }
        
        $model->motpasse = '';
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('login', ['model' => $model]);
        }
        return $this->render('login', ['model' => $model]);
    }

    public function actionReserver()
    {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    $id_voyage = Yii::$app->request->post('id_voyage');
    $nb_personnes = (int) Yii::$app->request->post('nb_personnes', 1); // Récupère le nombre
    $id_voyageur = Yii::$app->user->identity->id;

    $voyage = voyage::getVoyageId($id_voyage);
    
    if (!$voyage) {
        return ['success' => false, 'message' => 'Voyage introuvable.'];
    }
    
    // Vérifier qu'il y a assez de places disponibles
    if ($voyage->getPlacesDisponibles() < $nb_personnes) {
        return ['success' => false, 'message' => 'Pas assez de places disponibles.'];
    }

    $reservation = new reservation();
    $reservation->voyage = $id_voyage;
    $reservation->voyageur = $id_voyageur;
    $reservation->nbplaceresa = $nb_personnes; // Utilise le nombre demandé
    
    if ($reservation->save()) {
        return ['success' => true, 'message' => 'Réservation confirmée pour ' . $nb_personnes . ' place(s).'];
    } else {
        return ['success' => false, 'message' => 'Erreur technique lors de la réservation.'];
    }
    }

    public function actionProposer()
    {
        $model = new voyage();
        //Si l'utilisateur a rempli le formulaire et cliqué sur "Proposer"
        if ($model->load(Yii::$app->request->post())) {
            $model->conducteur = Yii::$app->user->identity->id;
            if (empty($user->permis)) {
            
            Yii::$app->session->setFlash('error', ' Vous devez renseigner votre numéro de permis dans votre profil pour proposer un trajet !');
            
            // On le renvoie à l'accueil (ou vers son profil pour qu'il le remplisse)
            return $this->goHome();
        }
            $trajetTrouve = trajet::getTrajet($model->ville_depart, $model->ville_arrivee);

            if ($trajetTrouve) {
                $model->trajet = $trajetTrouve->id;// On lie l'ID trouvé

                if ($model->save()) {
                    if (Yii::$app->request->isAjax) {
                        return $this->asJson([
                            'success' => true, 
                            'message' => 'Voyage publié avec succès !'
                        ]);
                    }
                    return $this->redirect(['site/index']);
                }
            } else {
                $model->addError('ville_depart', 'Trajet introuvable dans la base.');
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('proposer', ['model' => $model]);
        }
        return $this->render('proposer', ['model' => $model]);
    }

    // Profil Utilisateur
    public function actionProfil()
    {
        $user = Yii::$app->user->identity;

        $mesReservations = reservation::getReservationsByVoyageur($user->id);        
        $mesVoyagesProposes = voyage::getVoyagesByConducteur($user->id);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('profil', [
                'user' => $user,
                'reservations' => $mesReservations,
                'voyagesProposes' => $mesVoyagesProposes,
            ]);
        }

        return $this->render('profil', [
            'user' => $user,
            'reservations' => $mesReservations,
            'voyagesProposes' => $mesVoyagesProposes,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}