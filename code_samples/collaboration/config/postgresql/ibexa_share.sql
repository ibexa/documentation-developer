CREATE TABLE ibexa_collaboration
(
    id              SERIAL       NOT NULL,
    owner_id        INT          NOT NULL,
    token           VARCHAR(160) NOT NULL,
    discriminator   VARCHAR(190) NOT NULL,
    is_active       BOOLEAN      NOT NULL,
    has_public_link BOOLEAN      NOT NULL,
    created_at      TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    updated_at      TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX ibexa_collaboration_token_idx ON ibexa_collaboration (token);
CREATE INDEX ibexa_collaboration_owner_idx ON ibexa_collaboration (owner_id);
CREATE UNIQUE INDEX ibexa_collaboration_token_uc ON ibexa_collaboration (token);
COMMENT
ON COLUMN ibexa_collaboration.created_at IS '(DC2Type:datetimetz_immutable)';
COMMENT
ON COLUMN ibexa_collaboration.updated_at IS '(DC2Type:datetimetz_immutable)';
CREATE TABLE ibexa_collaboration_participant
(
    id            SERIAL       NOT NULL,
    session_id    INT          NOT NULL,
    discriminator VARCHAR(190) NOT NULL,
    scope         VARCHAR(255) DEFAULT NULL,
    token         VARCHAR(255) DEFAULT NULL,
    created_at    TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    updated_at    TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    PRIMARY KEY (id)
);
CREATE INDEX ibexa_collaboration_participant_idx ON ibexa_collaboration_participant (session_id);
CREATE UNIQUE INDEX ibexa_collaboration_participant_token_idx ON ibexa_collaboration_participant (token);
COMMENT
ON COLUMN ibexa_collaboration_participant.created_at IS '(DC2Type:datetimetz_immutable)';
COMMENT
ON COLUMN ibexa_collaboration_participant.updated_at IS '(DC2Type:datetimetz_immutable)';
CREATE TABLE ibexa_collaboration_participant_internal
(
    id      INT NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (id)
);
CREATE INDEX ibexa_collaboration_participant_internal_idx ON ibexa_collaboration_participant_internal (user_id);
CREATE TABLE ibexa_collaboration_participant_external
(
    id    INT          NOT NULL,
    email VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
CREATE TABLE ibexa_collaboration_invitation
(
    id             SERIAL      NOT NULL,
    session_id     INT         NOT NULL,
    participant_id INT         NOT NULL,
    sender_id      INT         NOT NULL,
    status         VARCHAR(64) NOT NULL,
    context        JSON DEFAULT NULL,
    created_at     TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    updated_at     TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    PRIMARY KEY (id)
);
CREATE INDEX ibexa_collaboration_invitation_idx ON ibexa_collaboration_invitation (session_id);
CREATE INDEX ibexa_collaboration_invitation_idx ON ibexa_collaboration_invitation (participant_id);
CREATE INDEX ibexa_collaboration_invitation_idx ON ibexa_collaboration_invitation (sender_id);
COMMENT
ON COLUMN ibexa_collaboration_invitation.created_at IS '(DC2Type:datetimetz_immutable)';
COMMENT
ON COLUMN ibexa_collaboration_invitation.updated_at IS '(DC2Type:datetimetz_immutable)';
ALTER TABLE ibexa_collaboration
    ADD CONSTRAINT ibexa_collaboration_owner_id_fk FOREIGN KEY (owner_id) REFERENCES ezuser (contentobject_id) ON DELETE RESTRICT NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ibexa_collaboration_participant
    ADD CONSTRAINT ibexa_collaboration_participant_session_id_fk FOREIGN KEY (session_id) REFERENCES ibexa_collaboration (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ibexa_collaboration_participant_internal
    ADD CONSTRAINT ibexa_collaboration_participant_internal_pk FOREIGN KEY (id) REFERENCES ibexa_collaboration_participant (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ibexa_collaboration_participant_internal
    ADD CONSTRAINT ibexa_collaboration_participant_internal_user_id_fk FOREIGN KEY (user_id) REFERENCES ezuser (contentobject_id) ON DELETE RESTRICT NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ibexa_collaboration_participant_external
    ADD CONSTRAINT ibexa_collaboration_participant_external_pk FOREIGN KEY (id) REFERENCES ibexa_collaboration_participant (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ibexa_collaboration_invitation
    ADD CONSTRAINT ibexa_collaboration_invitation_session_id_fk FOREIGN KEY (session_id) REFERENCES ibexa_collaboration (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ibexa_collaboration_invitation
    ADD CONSTRAINT ibexa_collaboration_invitation_participant_id_fk FOREIGN KEY (participant_id) REFERENCES ibexa_collaboration_participant (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ibexa_collaboration_invitation
    ADD CONSTRAINT ibexa_collaboration_invitation_sender_id_fk FOREIGN KEY (sender_id) REFERENCES ezuser (contentobject_id) ON DELETE RESTRICT NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE TABLE ibexa_collaboration_content 
(
	id INT NOT NULL, 
	content_id INT NOT NULL, 
	version_no INT NOT NULL, 
	language_id BIGINT NOT NULL, 
	PRIMARY KEY (id)
);

CREATE INDEX ibexa_collaboration_session_content_version_language_idx ON ibexa_collaboration_content (content_id, version_no, language_id);

ALTER TABLE ibexa_collaboration_content
	ADD CONSTRAINT ibexa_collaboration_content_pk FOREIGN KEY (id) REFERENCES ibexa_collaboration (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
