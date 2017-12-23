# magento2-auto-sku-generator
magento2 auto generate sku for new product based on custom confgiuration.
Auto SKU Generator Addon provides the functionality of generating the SKU automatically

# Installation

1.Copy the files to app/code/ directory.

2.Execute the following commands

php bin/magento setup:upgrade

php bin/magento setup:static-content:deploy

php bin/magento cache:flush

php bin/magento cache:clean

# Configuration

#### 1.Navigation
Store->Configuration->AUTO SKU->Configuration

#### 2.Prefix : 

Here you need to specify the prefix for the sku for example : D, AAA, DAC 

#### 3.Start From : 

Here you need to configure the start integer for example start from : 1

#### 4.SKU Length : 

This is the length of the sku, for example for length 5 -> D0001.

# ScreenShot
![ScreenShot](http://octonism.com/sgit/magento2-auto-sku-generation.png)


# Examples :-
#### 1 :  Prefix -> D, Start From -> 1, SKU Length -> 5
D00001, D0002, D0003 ,........

#### 3 :  Prefix -> SKU, Start From -> 1, SKU Length -> 7
SKU0001, SKU0002, SKU0003, SKU0004 ,....................

