#Installation steps
---------------------
EmiMatrix module installation is very easy, please follow the steps for installation-

1. Unzip the respective extension zip and  move the extracted directory into magento root directory {Project Root}/app/code/ folder.

Run Following Command via terminal
-----------------------------------
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento setup:db-declaration:generate-whitelist --module-name=Adobe_EmiMatrix

2. Flush the cache.
3. Creating New EMI options in Admin Panel.
    1. In admin panel navigate to **Catalog > Emi Matrix** and create new entry

4. Frontend
The Emi Option will appear in PDP page for simple and configurable product's next to product price

Limitations
-----------------
1. Doesn't work with text or visual swatches.
2. Each time a new EMI record added from backend. It requies a logout and login to frontend in order to reflect. 

Competibility
-----------------
Adobe Commerce OpenSource 2.4.2 - p2