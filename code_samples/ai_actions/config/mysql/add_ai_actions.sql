CREATE TABLE ibexa_action_configuration
(
    id                        INT auto_increment PRIMARY KEY,
    identifier                VARCHAR(64) NOT NULL,
    type                      VARCHAR(32) NOT NULL,
    enabled                   TINYINT(1) NOT NULL,
    action_type_options       JSON NULL,
    action_handler_options    JSON NULL,
    action_handler_identifier VARCHAR(64) NULL,
    created_at                DATETIME NULL COMMENT '(DC2Type:datetime_immutable)',
    updated_at                DATETIME NULL COMMENT '(DC2Type:datetime_immutable)',
    CONSTRAINT ibexa_action_configuration_identifier_uc UNIQUE (identifier)
) COLLATE = utf8mb4_unicode_520_ci;

CREATE INDEX ibexa_action_configuration_enabled_idx
    ON ibexa_action_configuration (enabled);

CREATE INDEX ibexa_action_configuration_identifier_idx
    ON ibexa_action_configuration (identifier);

CREATE TABLE ibexa_action_configuration_ml
(
    id                      INT auto_increment PRIMARY KEY,
    action_configuration_id INT          NOT NULL,
    language_id             BIGINT       NOT NULL,
    name                    VARCHAR(190) NOT NULL,
    description             LONGTEXT NULL,
    CONSTRAINT ibexa_action_configuration_ml_uidx
        UNIQUE (action_configuration_id, language_id),
    CONSTRAINT ibexa_action_configuration_ml_to_action_configuration_fk
        FOREIGN KEY (action_configuration_id) REFERENCES ibexa_action_configuration (id)
            ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT ibexa_action_configuration_ml_to_language_fk
        FOREIGN KEY (language_id) REFERENCES ezcontent_language (id)
            ON UPDATE CASCADE ON DELETE CASCADE
) COLLATE = utf8mb4_unicode_520_ci;

CREATE INDEX ibexa_action_configuration_ml_action_configuration_idx
    ON ibexa_action_configuration_ml (action_configuration_id);

CREATE INDEX ibexa_action_configuration_ml_language_idx
    ON ibexa_action_configuration_ml (language_id);
