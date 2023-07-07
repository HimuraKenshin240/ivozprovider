Feature: Retrieve active calls

  @createSchema
  Scenario: Retrieve my web theme json
    When I add "Accept" header equal to "application/json"
     And I send a "GET" request to "/my/theme"
    Then the response status code should be 200
     And the response should be in JSON
     And the header "Content-Type" should be equal to "application/json; charset=utf-8"
     And the JSON should be equal to:
      """
      {
          "name": "Platform Administration Portal",
          "theme": "redmond",
          "logo": "https://platform-ivozprovider.irontec.com/api/platform/my/logo/1/logo.jpeg"
      }
      """
