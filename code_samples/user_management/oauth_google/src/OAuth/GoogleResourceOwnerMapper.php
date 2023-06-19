<?php

declare(strict_types=1);

namespace App\OAuth;

use Ibexa\Contracts\Core\Repository\LanguageResolver;
use Ibexa\Contracts\Core\Repository\Repository;
use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType;
use Ibexa\Contracts\OAuth2Client\Repository\OAuth2UserService;
use Ibexa\OAuth2Client\ResourceOwner\ResourceOwnerToExistingOrNewUserMapper;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class GoogleResourceOwnerMapper extends ResourceOwnerToExistingOrNewUserMapper
{
    private const PROVIDER_PREFIX = 'google:';

    /** @var \Ibexa\Contracts\OAuth2Client\Repository\OAuth2UserService */
    private \Ibexa\Contracts\OAuth2Client\Repository\OAuth2UserService $userService;

    /** @var \Ibexa\Contracts\Core\Repository\LanguageResolver */
    private \Ibexa\Contracts\Core\Repository\LanguageResolver $languageResolver;

    /** @var string|null */
    private ?string $contentTypeIdentifier;

    /** @var string|null */
    private ?string $parentGroupRemoteId;

    public function __construct(
        Repository $repository,
        OAuth2UserService $userService,
        LanguageResolver $languageResolver,
        ?string $contentTypeIdentifier = null,
        ?string $parentGroupRemoteId = null
    ) {
        parent::__construct($repository);

        $this->userService = $userService;
        $this->languageResolver = $languageResolver;
        $this->contentTypeIdentifier = $contentTypeIdentifier;
        $this->parentGroupRemoteId = $parentGroupRemoteId;
    }

    /**
     * @param \League\OAuth2\Client\Provider\GoogleUser $resourceOwner
     */
    protected function loadUser(
        ResourceOwnerInterface $resourceOwner,
        UserProviderInterface $userProvider
    ): ?UserInterface {
        return $userProvider->loadUserByUsername($this->getUsername($resourceOwner));
    }

    /**
     * @param \League\OAuth2\Client\Provider\GoogleUser $resourceOwner
     */
    protected function createUser(
        ResourceOwnerInterface $resourceOwner,
        UserProviderInterface $userProvider
    ): ?UserInterface {
        $userCreateStruct = $this->userService->newOAuth2UserCreateStruct(
            $this->getUsername($resourceOwner),
            $resourceOwner->getEmail(),
            $this->getMainLanguageCode(),
            $this->getOAuth2UserContentType($this->repository)
        );

        $userCreateStruct->setField('first_name', $resourceOwner->getFirstName());
        $userCreateStruct->setField('last_name', $resourceOwner->getLastName());

        $parentGroups = [];
        if ($this->parentGroupRemoteId !== null) {
            $parentGroups[] = $this->userService->loadUserGroupByRemoteId($this->parentGroupRemoteId);
        }

        $this->userService->createUser($userCreateStruct, $parentGroups);

        return $userProvider->loadUserByUsername($this->getUsername($resourceOwner));
    }

    private function getOAuth2UserContentType(Repository $repository): ?ContentType
    {
        if ($this->contentTypeIdentifier !== null) {
            $contentTypeService = $repository->getContentTypeService();

            return $contentTypeService->loadContentTypeByIdentifier(
                $this->contentTypeIdentifier
            );
        }

        return null;
    }

    private function getMainLanguageCode(): string
    {
        // Get first prioritized language for current scope
        return $this->languageResolver->getPrioritizedLanguages()[0];
    }

    private function getUsername(GoogleUser $resourceOwner): string
    {
        return self::PROVIDER_PREFIX . $resourceOwner->getId();
    }
}
