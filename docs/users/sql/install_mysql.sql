CREATE TABLE
    ibexa_oauth2_client (
        id INT AUTO_INCREMENT NOT NULL,
        client_name VARCHAR(128) NOT NULL,
        client_identifier VARCHAR(32) NOT NULL,
        client_secret VARCHAR(128) DEFAULT NULL,
        client_active TINYINT (1) DEFAULT '0' NOT NULL,
        client_plain_pkce TINYINT (1) DEFAULT '0' NOT NULL,
        UNIQUE INDEX ibexa_oauth2_client_identifier_idx (client_identifier),
        PRIMARY KEY (id)
    ) DEFAULT CHARACTER
SET
    utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

CREATE TABLE
    ibexa_oauth2_client_redirect_uri (
        id INT AUTO_INCREMENT NOT NULL,
        client_id INT NOT NULL,
        client_redirect_uri VARCHAR(255) NOT NULL,
        INDEX ibexa_oauth2_client_redirect_uri_client_id_idx (client_id),
        INDEX ibexa_oauth2_client_redirect_uri_client_redirect_uri_idx (client_redirect_uri),
        UNIQUE INDEX ibexa_oauth2_client_redirect_uri_unique_idx (client_id, client_redirect_uri),
        PRIMARY KEY (id)
    ) DEFAULT CHARACTER
SET
    utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

CREATE TABLE
    ibexa_oauth2_client_grant (
        id INT AUTO_INCREMENT NOT NULL,
        client_id INT NOT NULL,
        client_grant VARCHAR(255) NOT NULL,
        INDEX ibexa_oauth2_client_grant_client_id_idx (client_id),
        INDEX ibexa_oauth2_client_grant_client_grant_idx (client_grant),
        UNIQUE INDEX ibexa_oauth2_client_grant_unique_idx (client_id, client_grant),
        PRIMARY KEY (id)
    ) DEFAULT CHARACTER
SET
    utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

CREATE TABLE
    ibexa_oauth2_client_token (
        id INT AUTO_INCREMENT NOT NULL,
        client_id INT NOT NULL,
        token_id INT NOT NULL,
        INDEX ibexa_oauth2_client_token_client_id_idx (client_id),
        INDEX ibexa_oauth2_client_token_token_id_idx (token_id),
        UNIQUE INDEX ibexa_oauth2_client_token_unique_idx (client_id, token_id),
        PRIMARY KEY (id)
    ) DEFAULT CHARACTER
SET
    utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

CREATE TABLE
    ibexa_oauth2_client_scope (
        id INT AUTO_INCREMENT NOT NULL,
        client_id INT NOT NULL,
        client_scope VARCHAR(255) NOT NULL,
        INDEX ibexa_oauth2_client_scope_client_id_idx (client_id),
        INDEX ibexa_oauth2_client_scope_client_scope_idx (client_scope),
        UNIQUE INDEX ibexa_oauth2_client_scope_unique_idx (client_id, client_scope),
        PRIMARY KEY (id)
    ) DEFAULT CHARACTER
SET
    utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

CREATE TABLE
    ibexa_oauth2_token_scope (
        id INT AUTO_INCREMENT NOT NULL,
        token_id INT NOT NULL,
        token_scope VARCHAR(255) NOT NULL,
        INDEX ibexa_oauth2_token_scope_token_id_idx (token_id),
        INDEX ibexa_oauth2_token_scope_scope_idx (token_scope),
        UNIQUE INDEX ibexa_oauth2_token_scope_unique_idx (token_id, token_scope),
        PRIMARY KEY (id)
    ) DEFAULT CHARACTER
SET
    utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

CREATE TABLE
    ibexa_oauth2_refresh_access_token (
        id INT AUTO_INCREMENT NOT NULL,
        access_token_id INT NOT NULL,
        refresh_token_id INT NOT NULL,
        INDEX ibexa_oauth2_refresh_access_token_access_token_id_idx (access_token_id),
        INDEX ibexa_oauth2_refresh_access_token_refresh_token_id_idx (refresh_token_id),
        UNIQUE INDEX ibexa_oauth2_refresh_access_token_unique_idx (access_token_id, refresh_token_id),
        PRIMARY KEY (id)
    ) DEFAULT CHARACTER
SET
    utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

CREATE TABLE
    ibexa_oauth2_consent (
        id INT AUTO_INCREMENT NOT NULL,
        user_identifier VARCHAR(150) NOT NULL,
        client_identifier VARCHAR(32) NOT NULL,
        created INT DEFAULT 0 NOT NULL,
        updated INT DEFAULT 0 NOT NULL,
        INDEX IDX_40497C0FD0494586 (user_identifier),
        INDEX IDX_40497C0FE77ABE2B (client_identifier),
        INDEX ibexa_oauth2_consent_consent_idx (user_identifier, client_identifier),
        UNIQUE INDEX ibexa_oauth2_consent_unique_idx (user_identifier, client_identifier),
        PRIMARY KEY (id)
    ) DEFAULT CHARACTER
SET
    utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

CREATE TABLE
    ibexa_oauth2_consent_scope (
        id INT AUTO_INCREMENT NOT NULL,
        consent_id INT NOT NULL,
        consent_scope VARCHAR(255) NOT NULL,
        INDEX ibexa_oauth2_consent_scope_consent_id_idx (consent_id),
        INDEX ibexa_oauth2_consent_scope_consent_scope_idx (consent_scope),
        UNIQUE INDEX ibexa_oauth2_consent_scope_unique_idx (consent_id, consent_scope),
        PRIMARY KEY (id)
    ) DEFAULT CHARACTER
SET
    utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

ALTER TABLE ibexa_oauth2_client_redirect_uri ADD CONSTRAINT ibexa_oauth2_client_redirect_uri_fk FOREIGN KEY (client_id) REFERENCES ibexa_oauth2_client (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ibexa_oauth2_client_grant ADD CONSTRAINT ibexa_oauth2_client_grant_fk FOREIGN KEY (client_id) REFERENCES ibexa_oauth2_client (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ibexa_oauth2_client_token ADD CONSTRAINT ibexa_oauth2_client_token_client_fk FOREIGN KEY (client_id) REFERENCES ibexa_oauth2_client (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ibexa_oauth2_client_token ADD CONSTRAINT ibexa_oauth2_client_token_token_fk FOREIGN KEY (token_id) REFERENCES ibexa_token (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ibexa_oauth2_client_scope ADD CONSTRAINT ibexa_oauth2_client_scope_fk FOREIGN KEY (client_id) REFERENCES ibexa_oauth2_client (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ibexa_oauth2_token_scope ADD CONSTRAINT ibexa_oauth2_token_scope_fk FOREIGN KEY (token_id) REFERENCES ibexa_token (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ibexa_oauth2_refresh_access_token ADD CONSTRAINT ibexa_oauth2_refresh_access_token_access_token_fk FOREIGN KEY (access_token_id) REFERENCES ibexa_token (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ibexa_oauth2_refresh_access_token ADD CONSTRAINT ibexa_oauth2_refresh_access_token_refresh_token_fk FOREIGN KEY (refresh_token_id) REFERENCES ibexa_token (id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ibexa_oauth2_consent ADD CONSTRAINT ibexa_oauth2_consent_user_fk FOREIGN KEY (user_identifier) REFERENCES ezuser (login) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ibexa_oauth2_consent ADD CONSTRAINT ibexa_oauth2_consent_client_fk FOREIGN KEY (client_identifier) REFERENCES ibexa_oauth2_client (client_identifier) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ibexa_oauth2_consent_scope ADD CONSTRAINT ibexa_oauth2_consent_scope_fk FOREIGN KEY (consent_id) REFERENCES ibexa_oauth2_consent (id) ON UPDATE CASCADE ON DELETE CASCADE;
