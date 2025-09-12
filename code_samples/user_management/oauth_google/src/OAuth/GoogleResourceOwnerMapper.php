<?php

declare(strict_types=1);

namespace App\OAuth;

use Ibexa\Contracts\Core\Repository\LanguageResolver;
use Ibexa\Contracts\Core\Repository\Repository;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType;
use Ibexa\Contracts\OAuth2Client\Repository\OAuth2UserService;
use Ibexa\OAuth2Client\ResourceOwner\ResourceOwnerToExistingOrNewUserMapper;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class GoogleResourceOwnerMapper extends ResourceOwnerToExistingOrNewUserMapper
{
    private const string PROVIDER_PREFIX = 'google:';

    public function __construct(
        Repository $repository,
        private readonly OAuth2UserService $oauthUserService,
        private readonly LanguageResolver $languageResolver,
        private readonly UserService $userService,
        private readonly ?string $contentTypeIdentifier = null,
        private readonly ?string $parentGroupRemoteId = null
    ) {
        parent::__construct($repository);
    }

    /**
     * @param \League\OAuth2\Client\Provider\GoogleUser $resourceOwner
     */
    protected function loadUser(
        ResourceOwnerInterface $resourceOwner,
        UserProviderInterface $userProvider
    ): UserInterface {
        return $userProvider->loadUserByIdentifier($this->getUsername($resourceOwner));
    }

    /**
     * @param \League\OAuth2\Client\Provider\GoogleUser $resourceOwner
     */
    protected function createUser(
        ResourceOwnerInterface $resourceOwner,
        UserProviderInterface $userProvider
    ): UserInterface {
        $userCreateStruct = $this->oauthUserService->newOAuth2UserCreateStruct(
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

        return $userProvider->loadUserByIdentifier($this->getUsername($resourceOwner));
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
