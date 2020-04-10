enable apcu

cgi.fix_pathinfo=1

<!-- list all product -->

SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
