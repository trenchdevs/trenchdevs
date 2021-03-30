<?php

namespace App\Models\Sites;

use App\ApplicationType;
use App\User;

class Marketale extends AbstractSite
{

    protected $defaultRole = User::ROLE_BUSINESS_OWNER;

    public function domains(): array
    {
        return [
            'http://localhost:3000',
            'https://localhost:3000',
            'https://marketale.trenchapps.com/',
        ];
    }

    public function registrationValidationRules(): array
    {
        $rules = parent::registrationValidationRules();
        $rules['shop_name'] = 'required|string|max:255';
        return $rules;
    }

    public function getAppType(): ApplicationType
    {
        /** @var ApplicationType $ecommerceAppType */
        $ecommerceAppType = ApplicationType::findOrCreateByName('ecommerce');
        return $ecommerceAppType;
    }
}
