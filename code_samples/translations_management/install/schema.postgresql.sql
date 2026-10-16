CREATE TABLE IF NOT EXISTS ibexa_auto_translation (
    id SERIAL NOT NULL,
    provider_identifier VARCHAR(190) NOT NULL,
    content_id INT NOT NULL,
    version_no INT NOT NULL,
    source_language_id BIGINT NOT NULL,
    target_language_id BIGINT NOT NULL,
    review_status VARCHAR(64) NOT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    PRIMARY KEY(id)
);

CREATE INDEX IF NOT EXISTS ibexa_auto_translation_content_version_idx ON ibexa_auto_translation (content_id, version_no);
CREATE INDEX IF NOT EXISTS ibexa_auto_translation_target_language_idx ON ibexa_auto_translation (target_language_id);
CREATE INDEX IF NOT EXISTS ibexa_auto_translation_review_status_idx ON ibexa_auto_translation (review_status);
CREATE UNIQUE INDEX IF NOT EXISTS ibexa_auto_translation_context_uidx ON ibexa_auto_translation (content_id, version_no, source_language_id, target_language_id);
COMMENT ON COLUMN ibexa_auto_translation.created_at IS '(DC2Type:datetime_immutable)';
COMMENT ON COLUMN ibexa_auto_translation.updated_at IS '(DC2Type:datetime_immutable)';

CREATE TABLE IF NOT EXISTS ibexa_auto_translation_review_log (
    id SERIAL NOT NULL,
    auto_translation_id INT DEFAULT NULL,
    user_id INT NOT NULL,
    status VARCHAR(64) NOT NULL,
    operation VARCHAR(64) NOT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    PRIMARY KEY(id)
);

CREATE INDEX IF NOT EXISTS IDX_325A3B737CE350E8 ON ibexa_auto_translation_review_log (auto_translation_id);
CREATE INDEX IF NOT EXISTS ibexa_auto_translation_review_log_auto_translation_created_idx ON ibexa_auto_translation_review_log (auto_translation_id, created_at, id);
CREATE INDEX IF NOT EXISTS ibexa_auto_translation_review_log_status_created_idx ON ibexa_auto_translation_review_log (status, created_at);
CREATE INDEX IF NOT EXISTS ibexa_auto_translation_review_log_user_idx ON ibexa_auto_translation_review_log (user_id);
COMMENT ON COLUMN ibexa_auto_translation_review_log.created_at IS '(DC2Type:datetime_immutable)';

ALTER TABLE ibexa_auto_translation_review_log ADD CONSTRAINT ibexa_auto_translation_review_log_auto_translation_fk
    FOREIGN KEY (auto_translation_id) REFERENCES ibexa_auto_translation (id) ON UPDATE CASCADE ON DELETE SET NULL;
ALTER TABLE ibexa_auto_translation_review_log ADD CONSTRAINT ibexa_auto_translation_review_log_user_fk
    FOREIGN KEY (user_id) REFERENCES ibexa_user (contentobject_id) ON UPDATE CASCADE ON DELETE RESTRICT;
