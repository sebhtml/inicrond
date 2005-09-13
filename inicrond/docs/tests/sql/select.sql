SELECT
OOO_usrs.usr_id,
usr_name
FROM
OOO_usrs, OOO_groups_usrs
WHERE
usr_pending=1
AND
OOO_groups_usrs.usr_id=OOO_usrs.usr_id
AND
OOO_groups_usrs.group_id=1
