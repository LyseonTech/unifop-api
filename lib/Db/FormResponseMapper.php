<?php

namespace OCA\FormMail\Db;

use OCP\AppFramework\Db\QBMapper;
use OCP\IDBConnection;

class FormResponseMapper extends QBMapper
{
    public function __construct(IDBConnection $db) {
        parent::__construct($db, 'form_responses');
    }

    public function findAll($limit=null, $offset=null) {
        $qb = $this->db->getQueryBuilder();

        $qb->select('*')
           ->from('form_responses')
           ->setMaxResults($limit)
           ->setFirstResult($offset);

        return $this->findEntities($qb);
    }

}