# Centerpoint Large Print Laravel Application Development Notes

## Initial Prerequisite Steps

1. Install Github Desktop Client
2. Clone from Github
3. Install Xampp
4. Change Document root to location of repo
5. install composer
6. composer install in application root
7. Install Sublime text editor
8. Create/Edit .env file for random string
9. php artisan key:generate
10. Create database for application in phpmyadmin with db name, user name and password in env
11. php artisan migrate

## Customer Discounts and Standing Order Plans

- For all orders whether they are clearance or choice or whatever (except Trade) they get free shipping if they purchase five or more books. On Trade it is free shipping automatically and has a 25% discount from list price. So when a customer places an order or I should say adds a book to the cart it should check the system if that customer has a choice plan or not, if they do than use the correct discount, if the title is marked as a sale or lowprice title, than it needs to have that discount and not count towards the choice plan, also again Trade books are completely separate so if they do add a trade title than they only get the 25% discount. Titles can be differentiated in the Invent dbf under the INVNATURE field whether they are Center Point or Trade titles
- You will not see a choice option title in inventory under the SOPLAN because there isn't one.
- Choice option level is just a key to change a discount on any order that a customer may place as long as their account indicates a choice option plan.
- So there is no titles to reference for this because they can choose all centerpoint published titles only no trade.
- So if you look in vendor file and customer has a choice than any order they place gets that discount.
- If customer is on their profile page and wants to see what is coming next on the standing order plans that the system says they have then you have to build that list by looking at the inventory file and pulling the titles that represent or categorized for that particular standing order.
- **Choice Option 24, Choice Option 48, Choice Option 100, Platinum Fiction, Platinum Romans, Platinum Mystery,** etc. These are all major plans that you will see in the databases however we do subcategory on the actual titles back to a vendor plan. So If you look at a title, you will know it goes with PLATINUM ROMANCE we do this in the inventory file so when we create the standing orders it looks at the "SERIES" in the inventory file and this "SERIES" represents a standing order classification. So if you see a "CLASS A" in there that represents the PLATINUM FICTION line. Program needs to read vendor file, find ehat plans the customer has and then look at inventory to pull the correct titles that go with that plan. You can also reference SOPLAN in the inventory file as well this tells you what Standing Order plan the title belongs to.
- Now with Choice and trade these are two different standing order plans. 
- **Trade** is an automatic 25% and free shipping on any book no matter what.
- **Choice** has 3 different levels and what this does is an obligation agreement  that if the customer purchases so many titles ANNUALLY they get a certain discount on all orders.
- **Ledger**  is anyone who does not have a choice plan, the other standing order plans are not editable so the person cannot add or subtract to alter discount or quantity. 
- **Trade** and **Choice** and the occasional **Ledger** order are the only thing that will be ordered online.
- Only someone with a **choice option plan** will be able to order Center Point titles only for whatever choice plan they have. 
- **Trade** titles do not count toward the choice whatsoever so we keep track of how many books the customer has purchased on the choice within the set date range that they started or renewed.
- So when you see in the vendor file a customer has say a Western Level 1 and a choice option 48 that that means we automatically choose the western titles which you will be able to pick out from the inventory file and build an invoice for them to see what titles they are by using the SOPLAN column in inventory. And their choice will basically be daily orders that they requested through email phone or website. So if they buy a title online and the system sees they have a choice than those books will count toward choice and pick up the choice discount for the level they have. But the customer cannot touch the Western standing order. Now some customers do have the opportunity to adjust their standing order but they have to call in to do that and we call that a mix Standing Order which uses that.
- Series column along with ...

## MongoDB

https://docs.mongodb.com/manual/tutorial/install-mongodb-on-windows-unattended/

