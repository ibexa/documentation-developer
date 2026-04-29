<?php

namespace App\Security;

use Ibexa\Bundle\Core\DependencyInjection\Configuration\ConfigBuilderInterface;
use Ibexa\Bundle\Core\DependencyInjection\Security\PolicyProvider\PolicyProviderInterface;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;

class FormPolicyProvider implements PolicyProviderInterface, TranslationContainerInterface
{
    public function addPolicies(ConfigBuilderInterface $configBuilder): void
    {
        $configBuilder->addConfig([
            "form" => [
                "read_submissions" => null,
            ],
        ]);
    }

    public static function getTranslationMessages(): array
    {
        return [
            (new Message('role.policy.form', 'forms'))->setDesc('Forms'),
            (new Message('role.policy.form.all_functions', 'forms'))->setDesc('Forms / All functions'),
            (new Message('role.policy.form.read_submissions', 'forms'))->setDesc('Forms / Read submissions'),
        ];
    }
}
