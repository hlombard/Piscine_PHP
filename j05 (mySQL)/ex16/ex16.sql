SELECT COUNT(id_film) AS 'movies'
FROM member_history
WHERE (date BETWEEN DATE('2006-10-30') AND DATE('2007-07-27'))
OR DATE_FORMAT(date, '%m-%d') = '12-24';
