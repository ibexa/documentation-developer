CREATE TABLE
    ibexa_oauth2_client (
        id SERIAL NOT NULL,
        client_name VARCHAR(128) NOT NULL,
        client_identifier VARCHAR(32) NOT NULL,
        client_secret VARCHAR(128) DEFAULT NULL,
        client_active BOOLEAN DEFAULT 'false' NOT NULL,
        client_plain_pkce BOOLEAN DEFAULT 'false' NOT NULL,
        PRIMARY KEY (id)
    );

CREATE UNIQUE INDEX ibexa_oauth2_client_identifier_idx ON ibexa_oauth2_client (client_identifier);

CREATE TABLE
    ibexa_oauth2_client_redirect_uri (
        id SERIAL NOT NULL,
        client_id INT NOT NULL,
        client_redirect_uri VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    );

CREATE INDEX ibexa_oauth2_client_redirect_uri_client_id_idx ON ibexa_oauth2_client_redirect_uri (client_id);

CREATE INDEX ibexa_oauth2_client_redirect_uri_client_redirect_uri_idx ON ibexa_oauth2_client_redirect_uri (client_redirect_uri);

CREATE UNIQUE INDEX ibexa_oauth2_client_redirect_uri_unique_idx ON ibexa_oauth2_client_redirect_uri (client_id, client_redirect_uri);

CREATE TABLE
    ibexa_oauth2_client_grant (
        id SERIAL NOT NULL,
        client_id INT NOT NULL,
        client_grant VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    );

CREATE INDEX ibexa_oauth2_client_grant_client_id_idx ON ibexa_oauth2_client_grant (client_id);

CREATE INDEX ibexa_oauth2_client_grant_client_grant_idx ON ibexa_oauth2_client_grant (client_grant);

CREATE UNIQUE INDEX ibexa_oauth2_client_grant_unique_idx ON ibexa_oauth2_client_grant (client_id, client_grant);

CREATE TABLE
    ibexa_oauth2_client_token (
        id SERIAL NOT NULL,
        client_id INT NOT NULL,
        token_id INT NOT NULL,
        PRIMARY KEY (id)
    );

CREATE INDEX ibexa_oauth2_client_token_client_id_idx ON ibexa_oauth2_client_token (client_id);

CREATE INDEX ibexa_oauth2_client_token_token_id_idx ON ibexa_oauth2_client_token (token_id);

CREATE UNIQUE INDEX ibexa_oauth2_client_token_unique_idx ON ibexa_oauth2_client_token (client_id, token_id);

CREATE TABLE
    ibexa_oauth2_client_scope (
        id SERIAL NOT NULL,
        client_id INT NOT NULL,
        client_scope VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    );

CREATE INDEX ibexa_oauth2_client_scope_client_id_idx ON ibexa_oauth2_client_scope (client_id);

CREATE INDEX ibexa_oauth2_client_scope_client_scope_idx ON ibexa_oauth2_client_scope (client_scope);

CREATE UNIQUE INDEX ibexa_oauth2_client_scope_unique_idx ON ibexa_oauth2_client_scope (client_id, client_scope);

CREATE TABLE
    ibexa_oauth2_token_scope (
        id SERIAL NOT NULL,
        token_id INT NOT NULL,
        token_scope VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    );

CREATE INDEX ibexa_oauth2_token_scope_token_id_idx ON ibexa_oauth2_token_scope (token_id);

CREATE INDEX ibexa_oauth2_token_scope_scope_idx ON ibexa_oauth2_token_scope (token_scope);

CREATE UNIQUE INDEX ibexa_oauth2_token_scope_unique_idx ON ibexa_oauth2_token_scope (token_id, token_scope);

CREATE TABLE
    ibexa_oauth2_refresh_access_token (
        id SERIAL NOT NULL,
        access_token_id INT NOT NULL,
        refresh_token_id INT NOT NULL,
        PRIMARY KEY (id)
    );

CREATE INDEX ibexa_oauth2_refresh_access_token_access_token_id_idx ON ibexa_oauth2_refresh_access_token (access_token_id);

CREATE INDEX ibexa_oauth2_refresh_access_token_refresh_token_id_idx ON ibexa_oauth2_refresh_access_token (refresh_token_id);

CREATE UNIQUE INDEX ibexa_oauth2_refresh_access_token_unique_idx ON ibexa_oauth2_refresh_access_token (access_token_id, refresh_token_id);

CREATE TABLE
    ibexa_oauth2_consent (
        id SERIAL NOT NULL,
        user_identifier VARCHAR(150) NOT NULL,
        client_identifier VARCHAR(32) NOT NULL,
        created INT DEFAULT 0 NOT NULL,
        updated INT DEFAULT 0 NOT NULL,
        PRIMARY KEY (id)
    );

CREATE INDEX IDX_40497C0FD0494586 ON ibexa_oauth2_consent (user_identifier);

CREATE INDEX IDX_40497C0FE77ABE2B ON ibexa_oauth2_consent (client_identifier);

CREATE INDEX ibexa_oauth2_consent_consent_idx ON ibexa_oauth2_consent (user_identifier, client_identifier);

CREATE UNIQUE INDEX ibexa_oauth2_consent_unique_idx ON ibexa_oauth2_consent (user_identifier, client_identifier);

CREATE TABLE
    ibexa_oauth2_consent_scope (
        id SERIAL NOT NULL,
        consent_id INT NOT NULL,
        consent_scope VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    );

CREATE INDEX ibexa_oauth2_consent_scope_consent_id_idx ON ibexa_oauth2_consent_scope (consent_id);

CREATE INDEX ibexa_oauth2_consent_scope_consent_scope_idx ON ibexa_oauth2_consent_scope (consent_scope);

CREATE UNIQUE INDEX ibexa_oauth2_consent_scope_unique_idx ON ibexa_oauth2_consent_scope (consent_id, consent_scope);

ALTER TABLE ibexa_oauth2_client_redirect_uri ADD CONSTRAINT ibexa_oauth2_client_redirect_uri_fk FOREIGN KEY (client_id) REFERENCES ibexa_oauth2_client (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE ibexa_oauth2_client_grant ADD CONSTRAINT ibexa_oauth2_client_grant_fk FOREIGN KEY (client_id) REFERENCES ibexa_oauth2_client (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE ibexa_oauth2_client_token ADD CONSTRAINT ibexa_oauth2_client_token_client_fk FOREIGN KEY (client_id) REFERENCES ibexa_oauth2_client (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE ibexa_oauth2_client_token ADD CONSTRAINT ibexa_oauth2_client_token_token_fk FOREIGN KEY (token_id) REFERENCES ibexa_token (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE ibexa_oauth2_client_scope ADD CONSTRAINT ibexa_oauth2_client_scope_fk FOREIGN KEY (client_id) REFERENCES ibexa_oauth2_client (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE ibexa_oauth2_token_scope ADD CONSTRAINT ibexa_oauth2_token_scope_fk FOREIGN KEY (token_id) REFERENCES ibexa_token (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE ibexa_oauth2_refresh_access_token ADD CONSTRAINT ibexa_oauth2_refresh_access_token_access_token_fk FOREIGN KEY (access_token_id) REFERENCES ibexa_token (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE ibexa_oauth2_refresh_access_token ADD CONSTRAINT ibexa_oauth2_refresh_access_token_refresh_token_fk FOREIGN KEY (refresh_token_id) REFERENCES ibexa_token (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE ibexa_oauth2_consent ADD CONSTRAINT ibexa_oauth2_consent_user_fk FOREIGN KEY (user_identifier) REFERENCES ezuser (login) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE ibexa_oauth2_consent ADD CONSTRAINT ibexa_oauth2_consent_client_fk FOREIGN KEY (client_identifier) REFERENCES ibexa_oauth2_client (client_identifier) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE ibexa_oauth2_consent_scope ADD CONSTRAINT ibexa_oauth2_consent_scope_fk FOREIGN KEY (consent_id) REFERENCES ibexa_oauth2_consent (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
