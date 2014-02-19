<?php
/*
 * Enum substitute
 * @package X2CRM.modules.newsletters.models
 */
final class NewsletterType {
    const Daily = 0;
    const Weekly = 1;
    const Monthly = 2;

    //To prevent it from being instantiated
    private function NewsletterType() {}
}
