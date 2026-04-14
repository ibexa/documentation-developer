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
