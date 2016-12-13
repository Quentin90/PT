<?php
namespace App\Model;
use Silex\Application;

use Doctrine\DBAL\Query\QueryBuilder;

class TypeEvenementModel {

    private $db;

    public function __construct(Application $app) {
        $this->db = $app['db'];
    }

    public function getAllTypeEvenement() {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('v.id_categorie', 'v.libelle')
            ->from('categorie', 'v')
            ->addOrderBy('v.libelle', 'ASC');
        return $queryBuilder->execute()->fetchAll();
    }
}