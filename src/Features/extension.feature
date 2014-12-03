Feature: WebitGlsBundle - Service container extension
  In order to bootstrap GLS-ADE and GLS Track & Trace libraries
  As a developer
  I want register GLS-ADE and GLS Track & Trace libraries services in Container

  Scenario: Loading services
    Given application is up
    Then there should be following services in container:
    """
    webit_gls.account_manager.default, webit_gls.account_manager,
    webit_gls.api_provider.default, webit_gls.api_provider
    """

  Scenario: Loading configuration with ADE accounts to AccountManager
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

  Scenario: Loading configuration with Track & Trace accounts to AccountManager
    Given application config contains:
    """
    webit_gls:
        track_accounts:
            alias-1:
                username: test-username
                password: test-password
            alias-2:
                username: test-username2
                password: test-password2
    """
    When application is up
    Then there should be following Accounts in AccountManager:
      | type   | alias   | username        | password       |
      | track  | alias-1 | test-username   | test-password  |
      | track  | alias-2 | test-username2  | test-password2 |
