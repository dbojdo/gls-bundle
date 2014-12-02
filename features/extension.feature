Feature: Service container extension
  In order to bootstrap SOAP-API library
  As a developer
  I want register SOAP-API library services in service container

  Scenario: Loading extension
    Given application is up
    Then there should be following services in container:
    """
    webit_gls.account_manager.default, webit_gls.account_manager,
    webit_gls.api_provider.default, webit_gls.api_provider
    """

  Scenario: Loading ADE accounts to AccountManager
    Given application config contains:
    """
    webit_gls:
        ade_accounts:
            alias-1:
                username: test-username
                password: test-password
                test_mode: true
            alias-2:
                username: test-username2
                password: test-password2
                test_mode: false
    """
    When application is up
    Then there should be following Accounts in AccountManager:
      | type | alias   | username       | password       | test  |
      | ade  | alias-1 | test-username  | test-password  | true  |
      | ade  | alias-2 | test-username2 | test-password2 | false |

  Scenario: Loading Track accounts to AccountManager
    Given application config contains:
    """
    webit_gls:
        track_accounts:
            alias-1:
                username: test-username
                password: test-password
    """
    When application is up
    Then there should be following Accounts in AccountManager:
      | type   | alias   | username       | password       |
      | track  | alias-1 | test-username  | test-password  |
