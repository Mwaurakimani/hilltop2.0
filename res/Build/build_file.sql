-- -----------------------------------------------------
-- Table `hilltopw_model`.`tbl_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltopw_model`.`tbl_users` (
  `userID` INT NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(45) NULL,
  `lastName` VARCHAR(45) NULL,
  `username` VARCHAR(45) NULL,
  `email` VARCHAR(255) NULL,
  `password` VARCHAR(255) NULL,
  `IDNumber` VARCHAR(20) NULL,
  `status` VARCHAR(10) NULL,
  `userGroup` VARCHAR(20) NULL,
  `dateCreated` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModified` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userID`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltopw_model`.`tbl_catalogue`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltopw_model`.`tbl_catalogue` (
  `productId` INT NOT NULL AUTO_INCREMENT,
  `productName` VARCHAR(255) NOT NULL,
  `currentStock` INT NULL,
  `units` VARCHAR(45) NULL,
  `min_limit` DECIMAL(15,2) NULL,
  `max_limit` DECIMAL(15,2) NULL,
  `sale_price` DECIMAL(15,2) NULL,
  `supply_price` DECIMAL(15,2) NULL,
  `date_created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `modified_by` INT NULL,
  `notes` MEDIUMTEXT NULL,
  `allow_stock_tracking` TINYINT NULL DEFAULT 0,
  PRIMARY KEY (`productId`),
  INDEX `bind_creator_idx` (`created_by` ASC),
  INDEX `bind_modify_idx` (`modified_by` ASC),
  UNIQUE INDEX `productName_UNIQUE` (`productName` ASC),
  CONSTRAINT `bind_creator`
    FOREIGN KEY (`created_by`)
    REFERENCES `hilltopw_model`.`tbl_users` (`userID`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `bind_modify`
    FOREIGN KEY (`modified_by`)
    REFERENCES `hilltopw_model`.`tbl_users` (`userID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltopw_model`.`tbl_sales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltopw_model`.`tbl_sales` (
  `sale_ID` INT NOT NULL AUTO_INCREMENT,
  `fk_saleRep` INT NULL,
  `saleType` VARCHAR(45) NULL,
  `sale_amount` DECIMAL(15,2) NULL,
  `dateCreated` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sale_ID`),
  INDEX `bind_sale_creator_idx` (`fk_saleRep` ASC),
  CONSTRAINT `bind_sale_creator`
    FOREIGN KEY (`fk_saleRep`)
    REFERENCES `hilltopw_model`.`tbl_users` (`userID`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltopw_model`.`tbl_subSale`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltopw_model`.`tbl_subSale` (
  `subSaleID` INT NOT NULL AUTO_INCREMENT,
  `fk_saleID` INT NULL,
  `fk_product` INT NULL,
  `quantity` INT NULL,
  `price` DECIMAL(15,2) NULL,
  `sub_total` DECIMAL(15,2) NULL,
  `dateCreated` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  PRIMARY KEY (`subSaleID`),
  INDEX `sub_sale_bind_idx` (`fk_saleID` ASC),
  INDEX `sub_product_bind_idx` (`fk_product` ASC),
  INDEX `bind_sub_order_creator_idx` (`created_by` ASC),
  CONSTRAINT `sub_sale_bind`
    FOREIGN KEY (`fk_saleID`)
    REFERENCES `hilltopw_model`.`tbl_sales` (`sale_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `sub_product_bind`
    FOREIGN KEY (`fk_product`)
    REFERENCES `hilltopw_model`.`tbl_catalogue` (`productId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `bind_sub_order_creator`
    FOREIGN KEY (`created_by`)
    REFERENCES `hilltopw_model`.`tbl_users` (`userID`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltopw_model`.`tbl_transactions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltopw_model`.`tbl_transactions` (
  `transactionID` INT NOT NULL AUTO_INCREMENT,
  `fk_saleRef` INT NULL,
  `Amount` DECIMAL(15,2) NULL,
  `Method` VARCHAR(20) NULL,
  `dateCreated` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `dateModified` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`transactionID`),
  INDEX `fk_sale_bind_idx` (`fk_saleRef` ASC),
  INDEX `fk_transaction_creator_idx` (`created_by` ASC),
  CONSTRAINT `fk_sale_bind`
    FOREIGN KEY (`fk_saleRef`)
    REFERENCES `hilltopw_model`.`tbl_sales` (`sale_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_transaction_creator`
    FOREIGN KEY (`created_by`)
    REFERENCES `hilltopw_model`.`tbl_users` (`userID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltopw_model`.`tbl_stockControl`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltopw_model`.`tbl_stockControl` (
  `Entry_ID` INT NOT NULL AUTO_INCREMENT,
  `fk_entryRep` INT NULL,
  `entryType` VARCHAR(45) NULL,
  `dateCreated` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModified` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdBy` INT NULL,
  `modifiedBy` INT NULL,
  `Summary` VARCHAR(255) NULL,
  `resolved` VARCHAR(25) NULL DEFAULT 'Unresolved',
  PRIMARY KEY (`Entry_ID`),
  INDEX `user_binder_idx` (`createdBy` ASC),
  INDEX `user_bind_modifier_idx` (`modifiedBy` ASC),
  INDEX `bind_restp_idx` (`fk_entryRep` ASC),
  CONSTRAINT `user_binder_creater`
    FOREIGN KEY (`createdBy`)
    REFERENCES `hilltopw_model`.`tbl_users` (`userID`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `user_bind_modifier`
    FOREIGN KEY (`modifiedBy`)
    REFERENCES `hilltopw_model`.`tbl_users` (`userID`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `bind_restp`
    FOREIGN KEY (`fk_entryRep`)
    REFERENCES `hilltopw_model`.`tbl_users` (`userID`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltopw_model`.`tbl_SubStockEntry`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltopw_model`.`tbl_SubStockEntry` (
  `EntryID` INT NOT NULL AUTO_INCREMENT,
  `fk_stockEntryID` INT NULL,
  `fk_product` INT NULL,
  `units` DECIMAL(15,2) NULL,
  `price` DECIMAL(15,2) NULL,
  `stk_returned` DECIMAL(15,2) NULL,
  `sale_price` DECIMAL(15,2) NULL,
  PRIMARY KEY (`EntryID`),
  INDEX `bind_stock_entry_idx` (`fk_stockEntryID` ASC),
  INDEX `bind_product_idx` (`fk_product` ASC),
  CONSTRAINT `bind_stock_entry`
    FOREIGN KEY (`fk_stockEntryID`)
    REFERENCES `hilltopw_model`.`tbl_stockControl` (`Entry_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `bind_product`
    FOREIGN KEY (`fk_product`)
    REFERENCES `hilltopw_model`.`tbl_catalogue` (`productId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
