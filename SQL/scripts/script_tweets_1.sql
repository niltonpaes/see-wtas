SELECT * FROM seewtas.tweets;

UPDATE 
`seewtas`.`tweets` SET 
`status_ok` = false,
`error` = null,
`status_toprod` = false,
`summary_en` = null,
`summary_ptbr` = null
WHERE (`index` > 0);


UPDATE 
`seewtas`.`tweets` SET 
`status_torun` = true
WHERE (`index` > 0);


UPDATE 
`seewtas`.`tweets` SET 
`error` = null
WHERE (`index` > 0);