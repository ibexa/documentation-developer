CREATE TABLE ibexa_collaboration_cart (
    id INTEGER NOT NULL PRIMARY KEY,
    cart_identifier VARCHAR(255) NOT NULL,
    CONSTRAINT ibexa_collaboration_cart_ibexa_collaboration_id_fk
        FOREIGN KEY (id) REFERENCES ibexa_collaboration (id)
            ON DELETE CASCADE
);
