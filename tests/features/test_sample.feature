Feature: Testing a sample project

Scenario: Testing getter and setter
  Given the following people exist:
     | name   | id |
     | saby   | 10  |
     | joe    | 20  |
     | tom    | 30  |

  Then id of name "saby" should be "10"
  Then name of id "20" should be "joe1"
  Then id of name "tom" should be "10"
