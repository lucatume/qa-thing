Feature: Manage super admins associated with a multisite instance

  Scenario: Add, list, and remove super admins.
    Given a WP multisite install
    When I run `wp user create superadmin superadmin@example.com`
    And I run `wp super-admin list`
    Then STDOUT should be:
      """
      admin
      """

    When I run `wp super-admin add superadmin`
    And I run `wp super-admin list`
    Then STDOUT should be:
      """
      admin
      superadmin
      """

    When I run `wp super-admin add superadmin`
    Then STDERR should contain:
      """
      Warning: User 'superadmin' already has super-admin capabilities.
      """

    When I run `wp super-admin list`
    Then STDOUT should be:
      """
      admin
      superadmin
      """

    When I run `wp super-admin list --format=table`
    Then STDOUT should be a table containing rows:
      | user_login |
      | admin      |
      | superadmin |

    When I run `wp super-admin remove admin`
    And I run `wp super-admin list`
    Then STDOUT should be:
      """
      superadmin
      """

    When I run `wp super-admin list --format=json`
    Then STDOUT should be:
      """
      [{"user_login":"superadmin"}]
      """
