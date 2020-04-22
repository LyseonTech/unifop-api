<?php

namespace OCA\FormMail\Db;

use OCP\AppFramework\Db\Entity;

class FormResponse extends Entity {
    protected $email;
    protected $name;
    protected $identity;
    protected $message;
    protected $phone;
    protected $created;

    /**
     * @return array
     */
	public function serialize(): array {
        return [
            'email' => $this->email,
            'name' => $this->name,
            'identity' => $this->identity,
            'message' => $this->message,
            'phone' => $this->phone,
            'created' => $this->created
        ];
    }
}