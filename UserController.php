<?php
namespace App\Controller;

use App\Model\UserModel;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;   // modif version 2.0

use Symfony\Component\HttpFoundation\Request;   // pour utiliser request

class UserController implements ControllerProviderInterface {

	private $UserModel;

	public function index(Application $app) {
		return $this->connexionUser($app);
	}

	public function connexionUser(Application $app)
	{
		return $app["twig"]->render('v_session_connexion.html.twig');
	}

	public function validFormConnexionUser(Application $app, Request $req)
	{

		$app['session']->clear();
		$donnees['login']=$req->get('login');
		$donnees['password']=$req->get('password');

		$this->UserModel = new UserModel($app);
		$data=$this->UserModel->verif_login_mdp_Utilisateur($donnees['login'],$donnees['password']);

		if($data != NULL)
		{
			$app['session']->set('droit', $data['droit']);  //dans twig {{ app.session.get('droit') }}
			$app['session']->set('login', $data['login']);
			$app['session']->set('logged', 1);
			$app['session']->set('user_id', $data['id']);
			return $app->redirect($app["url_generator"]->generate("accueil"));
		}
		else
		{
			$app['session']->set('erreur','mot de passe ou login incorrect');
			return $app["twig"]->render('v_session_connexion.html.twig');
		}
	}

    public function showUser(Application $app){
        $this->UserModel=new UserModel($app);
        $donnees=$this->UserModel->showUser();

        return $app["twig"]->render('backOff/User/show.html.twig',['donnees'=>$donnees]);

    }

	public function addUser(Application $app){
	    $this->UserModel=new UserModel($app);
        return $app["twig"]->render('backOff/User/add.html.twig');

    }
    public function validFormAddUser(Application $app, Request $req) {
        // var_dump($app['request']->attributes);
        if (isset($_POST['nom']) && isset($_POST['prenom']) and isset($_POST['ine']) and isset($_POST['mail'])and isset($_POST['mdp'])and isset($_POST['date_n'])
            and isset($_POST['filliere'])) {
            $donnees = [
                'nom' => htmlspecialchars($_POST['nom']),                    // echapper les entrées
                'prenom' => htmlspecialchars($_POST['prenom']),
                'ine' => htmlspecialchars($_POST['ine']),
                'mail' => htmlspecialchars($_POST['mail']),
                'mdp' => htmlspecialchars($_POST['mdp']),
                'date_n' => htmlspecialchars($_POST['date_n']),
                'filliere' => htmlspecialchars($_POST['filliere'])

            ];


            if(! empty($erreurs))
            {
                $this->UserModel = new UserModel($app);
                return $app["twig"]->render('backOff/User/add.html.twig',['donnees'=>$donnees,'erreurs'=>$erreurs]);
            }
            else
            {
                $this->UserModel = new UserModel($app);
                $this->UserModel->addUser($donnees);
                var_dump($donnees);
                return $app->redirect($app["url_generator"]->generate("user.showUser"));
            }

        }
        else

            return $app->abort(404, 'error Pb data form Add');
    }

	public function deconnexionSession(Application $app)
	{
		$app['session']->clear();
		$app['session']->getFlashBag()->add('msg', 'vous êtes déconnecté');
		return $app->redirect($app["url_generator"]->generate("accueil"));
	}

	public function connect(Application $app) {
		$controllers = $app['controllers_factory'];
		$controllers->match('/', 'App\Controller\UserController::index')->bind('user.index');
		$controllers->get('/login', 'App\Controller\UserController::connexionUser')->bind('user.login');
		$controllers->post('/login', 'App\Controller\UserController::validFormConnexionUser')->bind('user.validFormlogin');
        $controllers->get('/showUser', 'App\Controller\UserController::showUser')->bind('user.showUser');

        $controllers->get('/addUser', 'App\Controller\UserController::addUser')->bind('user.addUser');
        $controllers->post('/validFormAddUser', 'App\Controller\UserController::validFormAddUser')->bind('user.validFormAddUser');

		$controllers->get('/logout', 'App\Controller\UserController::deconnexionSession')->bind('user.logout');
		return $controllers;
	}
}