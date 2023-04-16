SELECT * FROM seewtas.reviews;

UPDATE 
`seewtas`.`reviews` SET 
`status_ok` = false,
`error` = null,
`status_toprod` = null,
`summary_en` = null,
`summary_ptbr` = null
WHERE (`index` > 0);


UPDATE 
`seewtas`.`reviews` SET 
`status_torun` = true
WHERE (`index` > 0);

UPDATE 
`seewtas`.`reviews` SET 
`error` = null
WHERE (`index` > 0);


UPDATE 
`seewtas`.`reviews` SET 
`status_toprod` = true
WHERE (`index` > 0);