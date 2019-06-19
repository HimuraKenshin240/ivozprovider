Feature: Retrieve holiday dates
  In order to manage holiday dates
  As a client admin
  I need to be able to retrieve them through the API.

  @createSchema
  Scenario: Retrieve the holiday dates json list
    Given I add Company Authorization header
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "holiday_dates"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the JSON should be equal to:
    """
      [
          {
              "name": "Name",
              "eventDate": "2021-12-21",
              "id": 1
          },
          {
              "name": "timeRangeEvent",
              "eventDate": "2021-12-21",
              "id": 2
          }
      ]
    """

  Scenario: Retrieve certain holiday date json
    Given I add Company Authorization header
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "holiday_dates/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the JSON should be equal to:
    """
      {
          "name": "Name",
          "eventDate": "2021-12-21",
          "wholeDayEvent": true,
          "timeIn": null,
          "timeOut": null,
          "routeType": null,
          "numberValue": null,
          "id": 1,
          "calendar": {
              "name": "testCalendar",
              "id": 1,
              "company": 1
          },
          "locution": null,
          "extension": null,
          "voiceMailUser": null,
          "numberCountry": null
      }
    """
