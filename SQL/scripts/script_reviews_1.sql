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



select 
	'reviews' as `table`,
	path,
	image,
	product_title,
	null as tweet_blockquote,
	summary_en,
	summary_ptbr,
	IF(
		TIMESTAMPDIFF(HOUR, created_at, NOW()) >= 24, 
		concat(FLOOR(TIMESTAMPDIFF(HOUR, created_at, NOW()) / 24) , ' day(s)'), 
		concat(FLOOR(TIMESTAMPDIFF(HOUR, created_at, NOW())) , ' hour(s)')
	)
	AS time_diff,
    TIMESTAMPDIFF(HOUR, created_at, NOW()) as time_hours_diff
from reviews where status_toprod is true
union
select 
	'tweets' as `table`,
	path,
	null as image,
	null product_title,
    tweet_blockquote,
	summary_en,
	summary_ptbr,
	IF(
		TIMESTAMPDIFF(HOUR, created_at, NOW()) >= 24, 
		concat(FLOOR(TIMESTAMPDIFF(HOUR, created_at, NOW()) / 24) , ' day(s)'), 
		concat(FLOOR(TIMESTAMPDIFF(HOUR, created_at, NOW())) , ' hour(s)')
	)
	AS time_diff,
    TIMESTAMPDIFF(HOUR, created_at, NOW()) as time_hours_diff
from tweets where status_toprod is true
order by time_hours_diff


