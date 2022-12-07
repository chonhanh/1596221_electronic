# SELECT PRODUCT
## QUAN 9
## SELECT t1.namevi as candidateName FROM table_product_candidate as t1 WHERE t1.id_district = 600;
## SELECT t2.namevi as constructName FROM table_product_construct as t2 WHERE t2.id_district = 600;
## SELECT t3.namevi as electronName FROM table_product_electron as t3 WHERE t3.id_district = 600;
## SELECT t4.namevi as employerName FROM table_product_employer as t4 WHERE t4.id_district = 600;
## SELECT t5.namevi as fashionName FROM table_product_fashion as t5 WHERE t5.id_district = 600;
## SELECT t6.namevi as realestateName FROM table_product_realestate as t6 WHERE t6.id_district = 600;
## SELECT t7.namevi as vehicleName FROM table_product_vehicle as t7 WHERE t7.id_district = 600;

## QUAN 2
## SELECT t1.namevi as candidateName FROM table_product_candidate as t1 WHERE t1.id_district = 607;
## SELECT t2.namevi as constructName FROM table_product_construct as t2 WHERE t2.id_district = 607;
## SELECT t3.namevi as electronName FROM table_product_electron as t3 WHERE t3.id_district = 607;
## SELECT t4.namevi as employerName FROM table_product_employer as t4 WHERE t4.id_district = 607;
## SELECT t5.namevi as fashionName FROM table_product_fashion as t5 WHERE t5.id_district = 607;
## SELECT t6.namevi as realestateName FROM table_product_realestate as t6 WHERE t6.id_district = 607;
## SELECT t7.namevi as vehicleName FROM table_product_vehicle as t7 WHERE t7.id_district = 607;

# UPDATE PRODUCT
## QUAN 9 => TP. THU DUC
## UPDATE table_product_candidate SET id_district = 600 WHERE id_district = 601;
## UPDATE table_product_construct SET id_district = 600 WHERE id_district = 601;
## UPDATE table_product_electron SET id_district = 600 WHERE id_district = 601;
## UPDATE table_product_employer SET id_district = 600 WHERE id_district = 601;
## UPDATE table_product_fashion SET id_district = 600 WHERE id_district = 601;
## UPDATE table_product_realestate SET id_district = 600 WHERE id_district = 601;
## UPDATE table_product_vehicle SET id_district = 600 WHERE id_district = 601;

## QUAN 2 => TP. THU DUC
## UPDATE table_product_candidate SET id_district = 600 WHERE id_district = 607;
## UPDATE table_product_construct SET id_district = 600 WHERE id_district = 607;
## UPDATE table_product_electron SET id_district = 600 WHERE id_district = 607;
## UPDATE table_product_employer SET id_district = 600 WHERE id_district = 607;
## UPDATE table_product_fashion SET id_district = 600 WHERE id_district = 607;
## UPDATE table_product_realestate SET id_district = 600 WHERE id_district = 607;
## UPDATE table_product_vehicle SET id_district = 600 WHERE id_district = 607;

# SELECT SHOP
## QUAN 9
## SELECT t2.name as constructName FROM table_shop_construct as t2 WHERE t2.id_district = 600;
## SELECT t3.name as electronName FROM table_shop_electron as t3 WHERE t3.id_district = 600;
## SELECT t5.name as fashionName FROM table_shop_fashion as t5 WHERE t5.id_district = 600;
## SELECT t6.name as realestateName FROM table_shop_realestate as t6 WHERE t6.id_district = 600;
## SELECT t7.name as vehicleName FROM table_shop_vehicle as t7 WHERE t7.id_district = 600;

## QUAN 2
## SELECT t2.name as constructName FROM table_shop_construct as t2 WHERE t2.id_district = 607;
## SELECT t3.name as electronName FROM table_shop_electron as t3 WHERE t3.id_district = 607;
## SELECT t5.name as fashionName FROM table_shop_fashion as t5 WHERE t5.id_district = 607;
## SELECT t6.name as realestateName FROM table_shop_realestate as t6 WHERE t6.id_district = 607;
## SELECT t7.name as vehicleName FROM table_shop_vehicle as t7 WHERE t7.id_district = 607;

# UPDATE SHOP
## QUAN 9 => TP. THU DUC
## UPDATE table_shop_construct SET id_district = 600 WHERE id_district = 601;
## UPDATE table_shop_electron SET id_district = 600 WHERE id_district = 601;
## UPDATE table_shop_fashion SET id_district = 600 WHERE id_district = 601;
## UPDATE table_shop_realestate SET id_district = 600 WHERE id_district = 601;
## UPDATE table_shop_vehicle SET id_district = 600 WHERE id_district = 601;

## QUAN 2 => TP. THU DUC
## UPDATE table_shop_construct SET id_district = 600 WHERE id_district = 607;
## UPDATE table_shop_electron SET id_district = 600 WHERE id_district = 607;
## UPDATE table_shop_fashion SET id_district = 600 WHERE id_district = 607;
## UPDATE table_shop_realestate SET id_district = 600 WHERE id_district = 607;
## UPDATE table_shop_vehicle SET id_district = 600 WHERE id_district = 607;

# SELECT MEMBER
## QUAN 9
## SELECT fullname FROM table_member WHERE id_district = 601;
## QUAN 2
## SELECT fullname FROM table_member WHERE id_district = 607;

# UPDATE MEMBER
## QUAN 9 => TP. THU DUC
## UPDATE table_member SET id_district = 600 WHERE id_district = 601;
## QUAN 2 => TP. THU DUC
## UPDATE table_member SET id_district = 600 WHERE id_district = 607;

# SELECT WARD
## QUAN 9
## SELECT id FROM table_wards WHERE id_city = 50 and id_district = 601;
## QUAN 2
## SELECT id FROM table_wards WHERE id_city = 50 and id_district = 607;

# UPDATE WARD
## QUAN 9 => TP. THU DUC
## UPDATE table_wards SET id_district = 600 WHERE id_city = 50 and id_district = 601;
## QUAN 2 => TP. THU DUC
## UPDATE table_wards SET id_district = 600 WHERE id_city = 50 and id_district = 607;