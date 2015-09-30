Feature: Testing verizon.com

@javascript
Scenario: Testing basic web features
   Given I am on the homepage
   Then I should see the text "ID: 10 Name: Tom"
