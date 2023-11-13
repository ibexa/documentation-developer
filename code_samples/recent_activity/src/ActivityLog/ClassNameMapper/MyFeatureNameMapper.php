<?php declare(strict_types=1);

namespace App\ActivityLog\ClassNameMapper;

use App\MyFeature\MyFeature;
use Ibexa\Contracts\ActivityLog\ClassNameMapperInterface;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;

class MyFeatureNameMapper implements ClassNameMapperInterface, TranslationContainerInterface
{
    public function getClassNameToShortNameMap(): iterable
    {
        yield MyFeature::class => 'my_feature';
    }

    public static function getTranslationMessages(): array
    {
        return [
            (new Message('ibexa.activity_log.search_form.object_class.my_feature', 'ibexa_activity_log'))
                ->setDesc('My Feature'),
        ];
    }
}
