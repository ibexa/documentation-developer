CREATE TABLE ibexa_shopping_list (
  id INT AUTO_INCREMENT NOT NULL,
  owner_id INT NOT NULL,
  identifier CHAR(36) NOT NULL COMMENT '(DC2Type:guid)',
  name VARCHAR(190) DEFAULT NULL,
  created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  is_default TINYINT(1) DEFAULT 0 NOT NULL,
  UNIQUE INDEX ibexa_shopping_list_identifier_idx (identifier),
  INDEX ibexa_shopping_list_owner_idx (owner_id),
  INDEX ibexa_shopping_list_default_idx (is_default),
  PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;
CREATE TABLE ibexa_shopping_list_entry (
  id INT AUTO_INCREMENT NOT NULL,
  shopping_list_id INT NOT NULL,
  product_code VARCHAR(64) NOT NULL,
  identifier CHAR(36) NOT NULL COMMENT '(DC2Type:guid)',
  added_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  UNIQUE INDEX ibexa_shopping_list_entry_identifier_idx (identifier),
  INDEX ibexa_shopping_list_entry_list_idx (shopping_list_id),
  INDEX ibexa_shopping_list_entry_product_idx (product_code),
  INDEX ibexa_shopping_list_entry_added_at_idx (added_at),
  UNIQUE INDEX ibexa_shopping_list_entry_unique (shopping_list_id, product_code),
  PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;
ALTER TABLE ibexa_shopping_list
  ADD CONSTRAINT ibexa_shopping_list_owner_fk FOREIGN KEY (owner_id) REFERENCES ibexa_user (contentobject_id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE ibexa_shopping_list_entry
  ADD CONSTRAINT ibexa_shopping_list_entry_list_fk FOREIGN KEY (shopping_list_id) REFERENCES ibexa_shopping_list (id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE ibexa_shopping_list_entry
  ADD CONSTRAINT ibexa_shopping_list_entry_product_fk FOREIGN KEY (product_code) REFERENCES ibexa_product (code) ON UPDATE CASCADE ON DELETE CASCADE;
