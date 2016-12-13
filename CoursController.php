<?php
namespace App\Controller;

use App\Model\UserModel;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;   // modif version 2.0

use Symfony\Component\HttpFoundation\Request;   // pour utiliser request

class CoursController implements ControllerProviderInterface {

    private $CoursModel;

    public function index(Application $app) {
        return $this->connexionCours($app);
    }

    public function showCours(Application $app){
        $this->CoursModel=new CoursModel($app);
        $donnees=$this->CoursModel->showCours();

        return $app["twig"]->render('backOff/Cours/show.html.twig',['donnees'=>$donnees]);

    }

    public function addCours(Application $app){
        $this->CoursModel=new CoursModel($app);
        return $app["twig"]->render('backOff/Cours/add.html.twig');

    }
    public function validFormAddCours(Application $app, Request $req) {
        // var_dump($app['request']->attributes);
        if (isset($_POST['id']) && isset($_POST['nom']) and isset($_POST['description']) and isset($_POST['id_user'])and isset($_POST['id_matiere'])){
            $donnees = [
                'id' => htmlspecialchars($_POST['id']),                    // echapper les entrées
                'nom' => htmlspecialchars($_POST['nom']),
                'description' => htmlspecialchars($_POST['description']),
                'id_user' => htmlspecialchars($_POST['id_user']),
                'id_matiere' => htmlspecialchars($_POST['id_matiere'])
            ];


            if(! empty($erreurs))
            {
                $this->CoursModel = new CoursModel($app);
                return $app["twig"]->render('backOff/Cours/add.html.twig',['donnees'=>$donnees,'erreurs'=>$erreurs]);
            }
            else
            {
                $this->CoursModel = new CoursModel($app);
                $this->CoursModel->addCours($donnees);
                var_dump($donnees);
                return $app->redirect($app["url_generator"]->generate("Cours.showCours"));
            }

        }
        else

            return $app->abort(404, 'error Pb data form Add');
    }


    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
        $controllers->match('/', 'App\Controller\CoursController::index')->bind('Cours.index');
        $controllers->get('/showCours', 'App\Controller\CoursController::showCours')->bind('Cours.showCours');

        $controllers->get('/addCours', 'App\Controller\CoursController::addCours')->bind('Cours.addCours');
        $controllers->post('/validFormAddCours', 'App\Controller\CoursController::validFormAddCours')->bind('Cours.validFormAddCours');

        return $controllers;
    }
}