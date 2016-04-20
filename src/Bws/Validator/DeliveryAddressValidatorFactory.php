<?php

namespace Bws\Validator;

use Symfony\Component\Yaml\Yaml;

class DeliveryAddressValidatorFactory
{
    /**
     * @param string $region
     *
     * @return DeliveryAddressValidator
     */
    public static function getDeliveryAddressValidator($region)
    {
        $validator = new DeliveryAddressValidator($region, Yaml::parse(
            file_get_contents(__DIR__ . '/../../../config/validation/delivery_address.yml')
        ));
        return $validator;
    }
}
