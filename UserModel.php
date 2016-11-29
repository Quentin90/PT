<?php
namespace App\Model;

use Silex\Application;
use Doctrine\DBAL\Query\QueryBuilder;;

class UserModel {

	private $db;

	public function __construct(Application $app) {
		$this->db = $app['db'];
	}

	public function verif_login_mdp_Utilisateur($login,$mdp){
		$sql = "SELECT id,login,password,droit FROM users WHERE login = ? AND password = ?";
		$res=$this->db->executeQuery($sql,[$login,$mdp]);   //md5($mdp);
		if($res->rowCount()==1)
			return $res->fetch();
		else
			return false;
	}
    public function showUser() {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('*')
            ->from('User');
        return $queryBuilder->execute()->fetchAll();

    }


	public function getUser($user_id) {
		$queryBuilder = new QueryBuilder($this->db);
		$queryBuilder
			->select('*')
			->from('users')
			->where('id = :idUser')
			->setParameter('idUser', $user_id);
		return $queryBuilder->execute()->fetch();

	}
    public function addUser($donnees) {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder->insert('User')
            ->values([
                'nom_user' => '?',
                'prenom_user' => '?',
                'N_INE'=> '?',
                'e_mail' => '?',
                'Mot_de_passe'=> '?',
                'date_naissance'=> '?',
                'filiere'=> '?',

            ])
            ->setParameter(0, $donnees['nom'])
            ->setParameter(1, $donnees['prenom'])
            ->setParameter(2, $donnees['ine'])
            ->setParameter(3, $donnees['mail'])
            ->setParameter(4, $donnees['mdp'])
            ->setParameter(5, $donnees['date_n'])
            ->setParameter(6, $donnees['filliere'])

        ;
        return $queryBuilder->execute();
    }
}