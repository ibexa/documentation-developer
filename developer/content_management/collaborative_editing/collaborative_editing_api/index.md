# Collaborative editing API

Use PHP API to manage invitations, sessions, and participants while using collaborative editing feature.

Ibexa DXP's Collaborative editing API provides two services for managing sessions and invitations, which differ in function:

- [`Ibexa\Contracts\Collaboration\InvitationServiceInterface`](../../../../../../ibexa/collaboration/src/contracts/InvitationServiceInterface.php) is used to manage collaboration sessions invitations
- [`Ibexa\Contracts\Collaboration\SessionServiceInterface`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php) is used to manage collaboration sessions

## Managing sessions

### Create session

You can create new collaboration session with [`SessionService::createSession()`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php):

```php
$versionInfo = $this->contentService->loadContent(52)->getVersionInfo();
$createStruct = new ContentSessionCreateStruct(
    $versionInfo,
    $versionInfo->getInitialLanguage()
);
$createStruct->setHasPublicLink(false);

$token = 'my-secret-token-12345';
$createStruct->setToken($token);

$sessionId = $this->sessionService->createSession($createStruct)->getId();
```

### Get session

You can get an existing collaboration session with [`SessionService::getSession()`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php):

- using given id - with [`SessionService::getSession()`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php)

```php
$session = $this->sessionService->getSession($sessionId);
```

- using given token - with [`SessionService::getSessionByToken()`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php)

```php
$session = $this->sessionService->getSessionByToken($token);
```

### Find sessions

You can find an existing session with [`SessionService::findSessions()`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php) by passing a SessionQuery object:

```php
$sessionQuery = new SessionQuery(new Token($token));
$session = $this->sessionService->findSessions($sessionQuery)->getFirst();
```

To learn more about the available search options, see [Search Criteria](../../../search/collaboration_search_reference/collaboration_criteria/index.md) and [Sort Clauses](../../../search/collaboration_search_reference/collaboration_sort_clauses/index.md) for Collaborative editing.

### Update session

You can update existing invitation with [`SessionService::updateSession()`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php):

```php
$updateStruct = new ContentSessionUpdateStruct();
$updateStruct->setHasPublicLink(true);

$this->sessionService->updateSession($session, $updateStruct);
```

### Delete session

You can delete session with [`SessionService::deleteSession()`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php):

```php
$this->sessionService->deleteSession($session);
```

## Managing participants

### Add participant

You can add participant to the collaboration session with [`SessionService::addParticipant()`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php):

```php
$user = $this->userService->loadUserByLogin('another_user');
$internalParticipantCreateStruct = new InternalParticipantCreateStruct(
    $user,
    ContentSessionScope::VIEW
);
$externalParticipantCreateStruct = new ExternalParticipantCreateStruct(
    'external@example.com',
    ContentSessionScope::VIEW,
    'personal-secret-token-12345'
);

$internalParticipant = $this->sessionService->addParticipant($session, $internalParticipantCreateStruct);
$externalParticipant = $this->sessionService->addParticipant($session, $externalParticipantCreateStruct);
```

### Get and update participant

You can update participant added to the collaboration session with [`SessionService::updateParticipant()`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php):

```php
$participant = $this->sessionService
    ->getSession($session->getId())
    ->getParticipants()
    ->getByEmail($user->email);

$internalParticipantUpdateStruct = new InternalParticipantUpdateStruct(ContentSessionScope::EDIT);
$this->sessionService->updateParticipant($session, $participant, $internalParticipantUpdateStruct);
```

The example below updates participant's permissions to allow for editing of shared content, not only previewing.

### Remove participant

You can remove participant from the collaboration session with [`SessionService::removeParticipant()`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php):

```php
$this->sessionService->removeParticipant($session, $externalParticipant);
```

### Check session owner

You can check whether a user belongs to a collaboration session with [`SessionService::isSessionOwner()`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceDecorator.php):

```php
$this->sessionService->isSessionOwner(
    $session,
    $this->userService->loadUserByLogin('another_user')
);
```

If no user is provided, current user is used.

### Check session participant

You can check the participant of the collaboration session with [`SessionService::isSessionParticipant()`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php):

```php
$this->sessionService->isSessionParticipant(
    $session,
    $this->permissionResolver->getCurrentUserReference()
);
```

## Managing invitations

### Manage invitation

You can get an invitation with [`InvitationService::getInvitation()`](../../../../../../ibexa/collaboration/src/contracts/InvitationServiceInterface.php):

```php
$invitation = $this->invitationService->getInvitationByParticipant($participant);
```

### Create invitation

You can create new invitation for the collaborative session using the [`InvitationService::createInvitation()`](../../../../../../ibexa/collaboration/src/contracts/InvitationServiceInterface.php) method:

```php
$invitationCreateStruct = new InvitationCreateStruct(
    $session,
    $internalParticipant
);

$this->invitationService->createInvitation($invitationCreateStruct);
```

You can use it when auto-inviting participants is not enabled.

### Update invitation

You can update existing invitation with [`InvitationService::updateInvitation()`](../../../../../../ibexa/collaboration/src/contracts/InvitationServiceInterface.php):

```php
$invitationUpdateStruct = new InvitationUpdateStruct();
$invitationUpdateStruct->setStatus(InvitationStatus::STATUS_REJECTED);

$this->invitationService->updateInvitation($invitation, $invitationUpdateStruct);
```

### Delete invitation

You can delete an invitation with [`InvitationService::deleteInvitation()`](../../../../../../ibexa/collaboration/src/contracts/InvitationServiceInterface.php):

```php
$invitation = $this->invitationService->getInvitation(2);
$this->invitationService->deleteInvitation($invitation);
```

### Find invitations

You can find an invitation with [`InvitationService::findInvitations()`](../../../../../../ibexa/collaboration/src/contracts/InvitationServiceInterface.php):

```php
$invitationQuery = new InvitationQuery(new Session($session));
$invitations = $this->invitationService->findInvitations($invitationQuery)->getInvitations();

foreach ($invitations as $invitation) {
    $output->writeln('Invitation ID: ' . $invitation->getId() . ' Status: ' . $invitation->getStatus());
}
```

To learn more about the available search options, see [Search Criteria](../../../search/collaboration_search_reference/collaboration_criteria/index.md) and [Sort Clauses](../../../search/collaboration_search_reference/collaboration_sort_clauses/index.md) for Collaborative editing.

## Example API usage

Below you can see an example of API usage for Collaborative editing:

```php
<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Collaboration\Invitation\InvitationCreateStruct;
use Ibexa\Contracts\Collaboration\Invitation\InvitationQuery;
use Ibexa\Contracts\Collaboration\Invitation\InvitationStatus;
use Ibexa\Contracts\Collaboration\Invitation\InvitationUpdateStruct;
use Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Session;
use Ibexa\Contracts\Collaboration\InvitationServiceInterface;
use Ibexa\Contracts\Collaboration\Participant\ExternalParticipantCreateStruct;
use Ibexa\Contracts\Collaboration\Participant\InternalParticipantCreateStruct;
use Ibexa\Contracts\Collaboration\Participant\InternalParticipantUpdateStruct;
use Ibexa\Contracts\Collaboration\Session\Query\Criterion\Token;
use Ibexa\Contracts\Collaboration\Session\SessionQuery;
use Ibexa\Contracts\Collaboration\SessionServiceInterface;
use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Share\Collaboration\ContentSessionCreateStruct;
use Ibexa\Contracts\Share\Collaboration\ContentSessionScope;
use Ibexa\Contracts\Share\Collaboration\ContentSessionUpdateStruct;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:manage-sessions')]
final class ManageSessionsCommand extends Command
{
    public function __construct(
        private readonly InvitationServiceInterface $invitationService,
        private readonly SessionServiceInterface $sessionService,
        private readonly ContentService $contentService,
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->permissionResolver->setCurrentUserReference(
            $this->userService->loadUserByLogin('admin')
        );

        // Create a sharing session for Content
        $versionInfo = $this->contentService->loadContent(52)->getVersionInfo();
        $createStruct = new ContentSessionCreateStruct(
            $versionInfo,
            $versionInfo->getInitialLanguage()
        );
        $createStruct->setHasPublicLink(false);

        $token = 'my-secret-token-12345';
        $createStruct->setToken($token);

        $sessionId = $this->sessionService->createSession($createStruct)->getId();

        // Get a session by ID or token
        $session = $this->sessionService->getSession($sessionId);
        $session = $this->sessionService->getSessionByToken($token);

        // Find sessions
        $sessionQuery = new SessionQuery(new Token($token));
        $session = $this->sessionService->findSessions($sessionQuery)->getFirst();

        // Update a session
        $updateStruct = new ContentSessionUpdateStruct();
        $updateStruct->setHasPublicLink(true);

        $this->sessionService->updateSession($session, $updateStruct);

        // Deactivate a session
        $updateStruct = new ContentSessionUpdateStruct();
        $updateStruct->setIsActive(false);

        $this->sessionService->updateSession($session, $updateStruct);

        // Manage participants
        $user = $this->userService->loadUserByLogin('another_user');
        $internalParticipantCreateStruct = new InternalParticipantCreateStruct(
            $user,
            ContentSessionScope::VIEW
        );
        $externalParticipantCreateStruct = new ExternalParticipantCreateStruct(
            'external@example.com',
            ContentSessionScope::VIEW,
            'personal-secret-token-12345'
        );

        $internalParticipant = $this->sessionService->addParticipant($session, $internalParticipantCreateStruct);
        $externalParticipant = $this->sessionService->addParticipant($session, $externalParticipantCreateStruct);

        // Get and update participants
        $participant = $this->sessionService
            ->getSession($session->getId())
            ->getParticipants()
            ->getByEmail($user->email);

        $internalParticipantUpdateStruct = new InternalParticipantUpdateStruct(ContentSessionScope::EDIT);
        $this->sessionService->updateParticipant($session, $participant, $internalParticipantUpdateStruct);

        // Remove participant
        $this->sessionService->removeParticipant($session, $externalParticipant);

        // Check ownerships. If no user is provided, current user is used.
        $this->sessionService->isSessionOwner(
            $session,
            $this->userService->loadUserByLogin('another_user')
        );

        // Check participation
        $this->sessionService->isSessionParticipant(
            $session,
            $this->permissionResolver->getCurrentUserReference()
        );

        // Manage invitations
        $invitationQuery = new InvitationQuery(new Session($session));
        $invitations = $this->invitationService->findInvitations($invitationQuery)->getInvitations();

        foreach ($invitations as $invitation) {
            $output->writeln('Invitation ID: ' . $invitation->getId() . ' Status: ' . $invitation->getStatus());
        }

        $invitation = $this->invitationService->getInvitationByParticipant($participant);

        // Create invitation - use when auto-inviting participants is not enabled
        $invitationCreateStruct = new InvitationCreateStruct(
            $session,
            $internalParticipant
        );

        $this->invitationService->createInvitation($invitationCreateStruct);

        // Update invitation
        $invitationUpdateStruct = new InvitationUpdateStruct();
        $invitationUpdateStruct->setStatus(InvitationStatus::STATUS_REJECTED);

        $this->invitationService->updateInvitation($invitation, $invitationUpdateStruct);

        // Delete invitation
        $invitation = $this->invitationService->getInvitation(2);
        $this->invitationService->deleteInvitation($invitation);

        // Delete a session
        $this->sessionService->deleteSession($session);

        return Command::SUCCESS;
    }
}
```
