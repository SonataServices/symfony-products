# features/store.feature
Feature: Insert new store
  In order to insert a store
  I need to fill the name and location

  Scenario: Insert new store  
  Given the following stores exist:
    | name                   | location             |
    | Soriana                | Blvd 2000            |
    | Bodega ahorerra        | Blvd. Aguacaliente   |
    | Farmacia la mas barata | Zona rio             |
  When I am on "/store/new"   