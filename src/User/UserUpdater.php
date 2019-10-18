<?php

namespace Baufragen\Sdk\User;

use Baufragen\Sdk\Services\UserService;

class UserUpdater {

    protected $id;

    protected $data = [];

    public function __construct($id) {
        $this->id = $id;
    }

    public function name($firstName, $lastName) {
        $this->data['firstname'] = $firstName ?? null;
        $this->data['lastname'] = $lastName ?? null;

        return $this;
    }

    public function update() {
        /** @var UserService $service */
        $service = app(UserService::class);

        return $service->executeUpdateUser($this);
    }

    public function getData() {
        return $this->data;
    }
}
