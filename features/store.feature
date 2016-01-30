# features/store.feature
Feature: CRUD Stores
  In order to test the Store module
  I have to test the Create, Read, Update
  and Delete actions

  Scenario Outline: Create, edit and delete new stores
  When I am on "/store/new"
  When I fill "appbundle_storetype[name]" with "<name>"
  When I fill "appbundle_storetype[location]" with "<location>"
  When I press "createButton"
  Then I should see "Store created successfully"
  When I click "Edit"
  When I fill "appbundle_storetype[name]" with "<nameEdit>"
  When I fill "appbundle_storetype[location]" with "<locationEdit>"
  When I press "Edit"
  Then I should see "Store edited successfully"
  When I press "Delete"
  Then I should see "Store deleted successfully"

  Examples:
  |  name           | location   |  nameEdit       | locationEdit      |
  |  test name 1    | location 1 |  edited name 1  | edited location 1 |
  |  test name 2    | location 2 |  edited name 2  | edited location 2 |
