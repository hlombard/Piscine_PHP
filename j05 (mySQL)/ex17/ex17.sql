SELECT COUNT(subscription.id_sub) AS 'nb_susc', FLOOR(AVG(subscription.price)) AS 'av_susc', MOD(SUM(subscription.duration_sub), 42) AS 'ft'
FROM subscription;
