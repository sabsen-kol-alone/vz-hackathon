Feature: Testing a Sample class

Scenario: Testing getter and setter methods
  Given the following people exist:
     | name   | id |
     | mike   | 10 |
     | joe    | 20 |
     | tom    | 30 |

  Then id of name "mike" should be "10"
  Then name of id "20" should be "joe"
  Then id of name "tom" should be "30"
