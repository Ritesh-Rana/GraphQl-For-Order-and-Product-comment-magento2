Download zip code from:
https://github.com/Ritesh-Rana/GQ

Steps to configure modules:

Extract zip file into magento directory app/code/
app/code/Abc/Def
app/code/GqRitesh/Assignment

Run the following commands in magento root directory:
sudo bin/magento setup:upgrade
sudo bin/magento setup:di:compile
sudo bin/magento cache:clean
sudo chmod -R 777 var/ generated/ pub/

Check if module GqRitesh_Assignment and Abc_Def are enabled or not in file app/etc/config.php if
Abc_Def => 1 and GqRitesh_Assignment => 1 this means modules are enabled.

Configuration for admin panel:
Shipping method:
Stores > Configuration > Sales > Delivery Methods >  Available Shipping Method only in specific country

Payment method:
Stores > Configuration > Sales > Payment Methods > OTHER PAYMENT METHODS > Test Payment
 	

Steps to run graphql queries:

Add one google chrome extension 
https://chrome.google.com/webstore/detail/altair-graphql-client/flnheeellpciglgpaodhkhmapeljopja?hl=en

Setup url 
http://hostname/graphql example:



Graphql Queries:

A). For edit or update entire order comment:

`{
  editCommentAttribute(
   	 id: 3,
   	entireOrderComment: "string")
  	{
    		entireOrderCommentUpdateFlag
    		id
    		updatedComment
  	}
}`
Where parameter `id` is order id or order number and `entireOrderComment` is comment         
that we have to update or edit. 




B). For edit or update customer attribute company name:

`{
  editCustomerAttributes(
email: "ritesh.rana@sigmainfo.net",
 companyName: "Sigma")
 {
    		flag
    		updatedCompanyName
  	}
}`
Where parameter `email` is of customer and `companyName` is company name that we have to update or edit


C). For edit or update Product Attribute unit of measure:

`{
  editProductAttributes(
 id: 0,
    	sku: "shirt",
    	unit: "l")
{
    		flag
    		sku
    		updatedUnit
  	}
}`
Where parameter `id` is product id ,`sku`  is sku of the product and `unit` unit of measure that we have to update or edit. In this unit can be ‘kg’,’l’,’gm’ or ‘ml’.
We can load product by its id or by sku, if loaded by sku then id should be 0.



D). For edit or update order comment for Product:

`{
  editProductComment(
    	id: 3,
    	sku: "shirt",
    	comment: "Please deliver as soon as soon")
{
    		flag
    		sku
    		updatedComment
  	}
}`
Where parameter `id` is order id or order number that can be obtain from placing order.
And `sku`  is the sku of the product that is available in placed order.
And `comment` is the comment that we need to update.  

Thanks.
