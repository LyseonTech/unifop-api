<?php

namespace OCA\FormMail\Db;

use OCP\AppFramework\Db\QBMapper;
use OCP\IDBConnection;

/**
 * @template-extends QBMapper<FormResponse>
 */
class FormResponseMapper extends QBMapper {
	public function __construct(IDBConnection $db) {
		parent::__construct($db, 'form_responses');
	}

	/**
	 * @return FormResponse[]
	 */
	public function findAll($limit = null, $offset = null): array {
		$qb = $this->db->getQueryBuilder();

		$qb->select('*')
		   ->from('form_responses')
		   ->setMaxResults($limit)
		   ->setFirstResult($offset);

		return $this->findEntities($qb);
	}

}
