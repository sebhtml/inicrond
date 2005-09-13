SELECT
result_id,
OOO_results.usr_id,
usr_name,
test_name,
OOO_tests.test_id,
time_GMT
FROM
OOO_results,
OOO_usrs,
OOO_tests

WHERE
OOO_tests.test_id=3