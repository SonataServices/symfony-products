# features/store.feature
Feature: CRUD Stores
  In order to test the Store module
  I have to test the Create, Read, Update
  and Delete actions

  Scenario Outline: Insert new store
  When I am on "/store/new"
  When I fill "appbundle_storetype[name]" with "<name>"
  When I fill "appbundle_storetype[location]" with "<location>"
  When I press "createButton"
  Then I should see "Store created successfully"

  Examples:
  |  name           | location   |
  |  test name 1    | location 1 |
  |  test name 2    | location 2 |

