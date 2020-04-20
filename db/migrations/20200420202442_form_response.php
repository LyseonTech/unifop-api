<?php

use Phinx\Migration\AbstractMigration;

class FormResponse extends AbstractMigration
{
    public function change()
    {

        $table = $this->table('form_responses');
        $table->addColumn('email', 'string', ['limit' => 100])
              ->addColumn('name', 'string', ['limit' => 100])
              ->addColumn('phone', 'string', ['limit' => 100])
              ->addColumn('identity', 'string', ['limit' => 100])
              ->addColumn('message', 'text')
              ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->create();
    }
}
