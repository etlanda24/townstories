SELECT *
FROM `tbl_location`
WHERE `city_id` = ? AND (
                          SELECT count(*)
                          FROM `tbl_location_content`
                          WHERE `tbl_location_content`.`location_id` = `tbl_location`.`location_id` AND (SELECT count(*)
                                                                                                         FROM
                                                                                                           `tbl_location_content_services`
                                                                                                         WHERE
                                                                                                           `tbl_location_content_services`.`location_content_id`
                                                                                                           =
                                                                                                           `tbl_location_content`.`id`
                                                                                                           AND (SELECT
                                                                                                                  count(
                                                                                                                      *)
                                                                                                                FROM
                                                                                                                  `tbl_services`
                                                                                                                WHERE
                                                                                                                  `tbl_services`.`id`
                                                                                                                  =
                                                                                                                  `tbl_location_content_services`.`service_id`
                                                                                                                  AND
                                                                                                                  `location_name`
                                                                                                                  LIKE ?
                                                                                                                  OR
                                                                                                                  `name`
                                                                                                                  LIKE
                                                                                                                  ?)
                                                                                                               >= 1) >=
                                                                                                        1) >= 1