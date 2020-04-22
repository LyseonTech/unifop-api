<?php

declare(strict_types=1);

namespace OCA\FormMail\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

/**
 * Auto-generated migration step: Please modify to your needs!
 */
class Version000002Date20200421193343 extends SimpleMigrationStep {

	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if (!$schema->hasTable('form_responses')) {
            $table = $schema->createTable('form_responses');
            $table->addColumn('id', 'integer', [
                'autoincrement' => true,
                'notnull' => true,
            ]);
            $table->addColumn('email', 'string', [
                'notnull' => true,
                'length' => 100
            ]);
            $table->addColumn('name', 'string', [
                'notnull' => true,
                'length' => 100,
            ]);
            $table->addColumn('phone', 'string', [
                'notnull' => true,
                'length' => 100,
            ]);
            $table->addColumn('identity', 'string', [
                'notnull' => true,
                'length' => 100,
            ]);
            $table->addColumn('message', 'text', [
                'notnull' => true
            ]);
            $table->addColumn('created', 'datetime', [
                'notnull' => true,
                'default' => 'CURRENT_TIMESTAMP'
            ]);

            $table->setPrimaryKey(['id']);
		}
		return $schema;
	}
}
