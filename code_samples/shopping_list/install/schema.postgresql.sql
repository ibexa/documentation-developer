CREATE TABLE ibexa_shopping_list (
  id SERIAL NOT NULL,
  owner_id INT NOT NULL,
  identifier UUID NOT NULL,
  name VARCHAR(190) DEFAULT NULL,
  created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
  updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
  is_default BOOLEAN DEFAULT false NOT NULL,
  PRIMARY KEY (id)
);
CREATE UNIQUE INDEX ibexa_shopping_list_identifier_idx ON ibexa_shopping_list (identifier);
CREATE INDEX ibexa_shopping_list_owner_idx ON ibexa_shopping_list (owner_id);
CREATE INDEX ibexa_shopping_list_default_idx ON ibexa_shopping_list (is_default);
COMMENT ON COLUMN ibexa_shopping_list.created_at IS '(DC2Type:datetime_immutable)';
COMMENT ON COLUMN ibexa_shopping_list.updated_at IS '(DC2Type:datetime_immutable)';
CREATE TABLE ibexa_shopping_list_entry (
  id SERIAL NOT NULL,
  shopping_list_id INT NOT NULL,
  product_code VARCHAR(64) NOT NULL,
  identifier UUID NOT NULL,
  added_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
  PRIMARY KEY (id)
);
CREATE UNIQUE INDEX ibexa_shopping_list_entry_identifier_idx ON ibexa_shopping_list_entry (identifier);
CREATE INDEX ibexa_shopping_list_entry_list_idx ON ibexa_shopping_list_entry (shopping_list_id);
CREATE INDEX ibexa_shopping_list_entry_product_idx ON ibexa_shopping_list_entry (product_code);
CREATE INDEX ibexa_shopping_list_entry_added_at_idx ON ibexa_shopping_list_entry (added_at);
CREATE UNIQUE INDEX ibexa_shopping_list_entry_unique ON ibexa_shopping_list_entry (shopping_list_id, product_code);
COMMENT ON COLUMN ibexa_shopping_list_entry.added_at IS '(DC2Type:datetime_immutable)';
ALTER TABLE ibexa_shopping_list
  ADD CONSTRAINT ibexa_shopping_list_owner_fk FOREIGN KEY (owner_id) REFERENCES ibexa_user (contentobject_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ibexa_shopping_list_entry
  ADD CONSTRAINT ibexa_shopping_list_entry_list_fk FOREIGN KEY (shopping_list_id) REFERENCES ibexa_shopping_list (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ibexa_shopping_list_entry
  ADD CONSTRAINT ibexa_shopping_list_entry_product_fk FOREIGN KEY (product_code) REFERENCES ibexa_product (code) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
