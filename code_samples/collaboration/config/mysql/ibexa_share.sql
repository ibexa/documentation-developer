CREATE TABLE ibexa_collaboration
(
    id              INT AUTO_INCREMENT NOT NULL,
    owner_id        INT                NOT NULL,
    token           VARCHAR(160)       NOT NULL,
    discriminator   VARCHAR(190)       NOT NULL,
    is_active       TINYINT(1)         NOT NULL,
    has_public_link TINYINT(1)         NOT NULL,
    created_at      DATETIME           NOT NULL COMMENT '(DC2Type:datetimetz_immutable)',
    updated_at      DATETIME           NOT NULL COMMENT '(DC2Type:datetimetz_immutable)',
    UNIQUE INDEX ibexa_collaboration_token_idx (token),
    INDEX ibexa_collaboration_owner_idx (owner_id),
    UNIQUE INDEX ibexa_collaboration_token_uc (token),
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
  COLLATE `utf8mb4_unicode_520_ci`
  ENGINE = InnoDB;
CREATE TABLE ibexa_collaboration_participant
(
    id            INT AUTO_INCREMENT NOT NULL,
    session_id    INT                NOT NULL,
    discriminator VARCHAR(190)       NOT NULL,
    scope         VARCHAR(255) DEFAULT NULL,
    token         VARCHAR(255) DEFAULT NULL,
    created_at    DATETIME           NOT NULL COMMENT '(DC2Type:datetimetz_immutable)',
    updated_at    DATETIME           NOT NULL COMMENT '(DC2Type:datetimetz_immutable)',
    INDEX IDX_9C5C6401613FECDF (session_id),
    UNIQUE INDEX ibexa_collaboration_participant_token_idx (token),
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
  COLLATE `utf8mb4_unicode_520_ci`
  ENGINE = InnoDB;
CREATE TABLE ibexa_collaboration_participant_internal
(
    id      INT NOT NULL,
    user_id INT NOT NULL,
    INDEX IDX_E838B79AA76ED395 (user_id),
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
  COLLATE `utf8mb4_unicode_520_ci`
  ENGINE = InnoDB;
CREATE TABLE ibexa_collaboration_participant_external
(
    id    INT          NOT NULL,
    email VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
  COLLATE `utf8mb4_unicode_520_ci`
  ENGINE = InnoDB;
CREATE TABLE ibexa_collaboration_invitation
(
    id             INT AUTO_INCREMENT NOT NULL,
    session_id     INT                NOT NULL,
    participant_id INT                NOT NULL,
    sender_id      INT                NOT NULL,
    status         VARCHAR(64)        NOT NULL,
    context        LONGTEXT DEFAULT NULL COMMENT '(DC2Type:json)',
    created_at     DATETIME           NOT NULL COMMENT '(DC2Type:datetimetz_immutable)',
    updated_at     DATETIME           NOT NULL COMMENT '(DC2Type:datetimetz_immutable)',
    INDEX IDX_36C63687613FECDF (session_id),
    INDEX IDX_36C636879D1C3019 (participant_id),
    INDEX IDX_36C63687F624B39D (sender_id),
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
  COLLATE `utf8mb4_unicode_520_ci`
  ENGINE = InnoDB;
ALTER TABLE ibexa_collaboration
    ADD CONSTRAINT ibexa_collaboration_owner_id_fk FOREIGN KEY (owner_id) REFERENCES ezuser (contentobject_id) ON DELETE RESTRICT;
ALTER TABLE ibexa_collaboration_participant
    ADD CONSTRAINT ibexa_collaboration_participant_session_id_fk FOREIGN KEY (session_id) REFERENCES ibexa_collaboration (id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE ibexa_collaboration_participant_internal
    ADD CONSTRAINT ibexa_collaboration_participant_internal_pk FOREIGN KEY (id) REFERENCES ibexa_collaboration_participant (id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE ibexa_collaboration_participant_internal
    ADD CONSTRAINT ibexa_collaboration_participant_internal_user_id_fk FOREIGN KEY (user_id) REFERENCES ezuser (contentobject_id) ON DELETE RESTRICT;
ALTER TABLE ibexa_collaboration_participant_external
    ADD CONSTRAINT ibexa_collaboration_participant_external_pk FOREIGN KEY (id) REFERENCES ibexa_collaboration_participant (id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE ibexa_collaboration_invitation
    ADD CONSTRAINT ibexa_collaboration_invitation_session_id_fk FOREIGN KEY (session_id) REFERENCES ibexa_collaboration (id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE ibexa_collaboration_invitation
    ADD CONSTRAINT ibexa_collaboration_invitation_participant_id_fk FOREIGN KEY (participant_id) REFERENCES ibexa_collaboration_participant (id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE ibexa_collaboration_invitation
    ADD CONSTRAINT ibexa_collaboration_invitation_sender_id_fk FOREIGN KEY (sender_id) REFERENCES ezuser (contentobject_id) ON DELETE RESTRICT;
CREATE TABLE ibexa_collaboration_content 
(
  id INT NOT NULL,
  content_id INT NOT NULL,
  version_no INT NOT NULL,
  language_id BIGINT NOT NULL,
  INDEX ibexa_collaboration_session_content_version_language_idx (content_id, version_no, language_id),
  PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;
ALTER TABLE
  ibexa_collaboration_content
ADD
  CONSTRAINT ibexa_collaboration_content_pk FOREIGN KEY (id) REFERENCES ibexa_collaboration (id) ON UPDATE CASCADE ON DELETE CASCADE;
