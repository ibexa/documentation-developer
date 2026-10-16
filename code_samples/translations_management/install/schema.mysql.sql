CREATE TABLE IF NOT EXISTS ibexa_auto_translation (
    id INT AUTO_INCREMENT NOT NULL,
    provider_identifier VARCHAR(190) NOT NULL,
    content_id INT NOT NULL,
    version_no INT NOT NULL,
    source_language_id BIGINT NOT NULL,
    target_language_id BIGINT NOT NULL,
    review_status VARCHAR(64) NOT NULL,
    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    INDEX ibexa_auto_translation_content_version_idx (content_id, version_no),
    INDEX ibexa_auto_translation_target_language_idx (target_language_id),
    INDEX ibexa_auto_translation_review_status_idx (review_status),
    UNIQUE INDEX ibexa_auto_translation_context_uidx (content_id, version_no, source_language_id, target_language_id),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS ibexa_auto_translation_review_log (
    id INT AUTO_INCREMENT NOT NULL,
    auto_translation_id INT DEFAULT NULL,
    user_id INT NOT NULL,
    status VARCHAR(64) NOT NULL,
    operation VARCHAR(64) NOT NULL,
    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    INDEX IDX_325A3B737CE350E8 (auto_translation_id),
    INDEX ibexa_auto_translation_review_log_auto_translation_created_idx (auto_translation_id, created_at, id),
    INDEX ibexa_auto_translation_review_log_status_created_idx (status, created_at),
    INDEX ibexa_auto_translation_review_log_user_idx (user_id),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

ALTER TABLE ibexa_auto_translation_review_log ADD CONSTRAINT ibexa_auto_translation_review_log_auto_translation_fk
    FOREIGN KEY (auto_translation_id) REFERENCES ibexa_auto_translation (id) ON UPDATE CASCADE ON DELETE SET NULL;
ALTER TABLE ibexa_auto_translation_review_log ADD CONSTRAINT ibexa_auto_translation_review_log_user_fk
    FOREIGN KEY (user_id) REFERENCES ibexa_user (contentobject_id) ON UPDATE CASCADE ON DELETE RESTRICT;
