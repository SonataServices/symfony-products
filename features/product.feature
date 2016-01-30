# features/store.feature
Feature: CRUD Product
  In order to test the Product module
  I have to test the Create, Read, Update
  and Delete actions

  Scenario Outline: Create, edit and delete new product
  When I am on "/product/new"
  When I fill "appbundle_producttype[name]" with "<name>"
  When I fill "appbundle_producttype[price]" with "<price>"
  When I select "appbundle_producttype[store]" with "56a124e4668ccb90af000029"
  When I press "createButton"
  Then I should see "Product created successfully"
  When I click "Edit"
  When I fill "appbundle_producttype[name]" with "<nameEdit>"
  When I fill "appbundle_producttype[price]" with "<priceEdit>"
  When I select "appbundle_producttype[store]" with "56a28c28668ccb4c1c000029"
  When I press "Edit"
  Then I should see "Product edited successfully"
  When I press "Delete"
  Then I should see "Product deleted successfully"

  Examples:
  |  name         | price |  nameEdit       | priceEdit |
  |  test name 1  | 623   |  edited name 1  | 111       |
  |  test name 2  | 911   |  edited name 2  | 222       |
