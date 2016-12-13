<?php
namespace App\Model;

use Silex\Application;
use Doctrine\DBAL\Query\QueryBuilder;;

class CoursModel {

    private $db;

    public function __construct(Application $app) {
        $this->db = $app['db'];
    }


    public function showCours() {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('*')
            ->from('Cours');
        return $queryBuilder->execute()->fetchAll();

    }


    public function getCours($id_cours) {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('*')
            ->from('Cours')
            ->where('id_cours = :idCours')
            ->setParameter('idCours', $id_cours);
        return $queryBuilder->execute()->fetch();

    }
    public function addCours($donnees) {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder->insert('Cours')
            ->values([
                'id_cours' => '?',
                'nom_cours' => '?',
                'description_cours'=> '?',
                'id_user' => '?',
                'id_matiere'=> '?',
            ])
            ->setParameter(0, $donnees['id'])
            ->setParameter(1, $donnees['nom'])
            ->setParameter(2, $donnees['description'])
            ->setParameter(3, $donnees['id_user'])
            ->setParameter(4, $donnees['id_matiere'])

        ;
        return $queryBuilder->execute();
    }
}