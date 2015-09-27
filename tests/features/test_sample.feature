Feature: Testing a sample project

Scenario: Testing getter and setter
  Given I set values "saby", "56", "1959-10-06"
  Then id "1" should get back "saby", "56", "1959-10-06"
