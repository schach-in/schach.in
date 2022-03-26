/**
 * Zugzwang Project
 * Copyright (c) 2022 Gustaf Mossakowski <gustaf@koenige.org>
 * System SQL queries
 */


-- auth_login --
SELECT password, identifier AS username, contact_id AS user_id, logins.person_id
, logins.login_id, contact_id, first_name, last_name
, (SELECT identification FROM contactdetails
	WHERE contactdetails.contact_id = contacts.contact_id
	AND provider_category_id = /*_ID categories provider/e-mail _*/
	LIMIT 1
) AS e_mail
, CONCAT(first_name, ' ', last_name) AS person 
, IF(password_change = 'yes', 1, NULL) as change_password
, IF(sex = 'male', 'man', IF(sex = 'female', 'woman', NULL)) AS subcategory
FROM logins
LEFT JOIN persons USING (person_id)
LEFT JOIN contacts USING (contact_id)
WHERE active = 'yes'
AND identifier = '%s';
