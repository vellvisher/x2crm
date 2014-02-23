<?php

/**
 * @package X2CRM.modules.advertise
 */
class AdvertiseModule extends CWebModule {
    public function init() {
        $this->setImport(array(
            'advertise.models.*',
            'advertise.controllers.*',
        ));
    }
}