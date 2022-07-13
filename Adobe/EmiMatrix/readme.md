#Problem statement:
---------------------

As an admin I need the ability to configure EMI matrix in Admin which then will be used to calculate EMI options that are available to a customer. 
The available EMI options can vary based on Gender and only Logged in customers should have the ability to view EMI options.
If a logged in customer has no gender information saved then EMI options applicable for male gender will be shown
 

Admin EMI matrix Configuration Fields  and sample values are as follow

| Interest Rate | Tenure (Months)  | Gender |
| ------- | --- | --- |
| 16 | 3 | Male |
| 12 | 6 | Male |
| 10 | 6 | Female |
| 10 | 12 | Male |

A Link EMI Options will be shown in Product Details Page. When a  customer clicks it, a dialog box should open which should contain the available EMI offers as depicted in below screenshot . The product price would be used to calculate EMI options.

#Acceptance Criteria:
---------------------
The solution should be modular and reusable
2. The solution should follow Magento best practices
3. The solution should support FPC 
4. The solution should support simple and configurable product


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
