Feature: Testing localhost

@javascript
Scenario: Testing basic web features
   Given I am on the homepage
#   Then I should see the text "Welcome to Home!"
   Then I should see the text "ID: 10 Name: Tom"

   Given I am at "/visual"
   Then I should see the text "Visual Functional Test Suite"
