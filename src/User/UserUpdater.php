<?php

namespace Baufragen\Sdk\User;

use Baufragen\Sdk\Services\UserService;

class UserUpdater {

    protected $id;

    protected $data = [];

    public function __construct($id) {
        $this->id = $id;
    }

    public function name($firstName = null, $lastName = null) {
        $this->data['firstname'] = $firstName;
        $this->data['lastname'] = $lastName;

        return $this;
    }

    public function position($position = null) {
        $this->data['position'] = $position;

        return $this;
    }

    public function contact($phone = null, $fax = null, $mobile = null) {
        $this->data['phone'] = $phone;
        $this->data['fax'] = $fax;
        $this->data['mobile'] = $mobile;

        return $this;
    }

    public function address($company = null, $street = null, $zip = null, $city = null, $countryId = null) {
        $this->data['company'] = $company;
        $this->data['street'] = $street;
        $this->data['zip'] = $zip;
        $this->data['city'] = $city;
        $this->data['country_id'] = $countryId;

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

    public function getUser() {
        return $this->id;
    }
}
