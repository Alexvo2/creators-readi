<?php

/**
 * Partial of the login page
 *
 * @link       http://webtexttool.com
 * @since      1.0.0
 *
 * @package    Webtexttool
 * @subpackage Webtexttool/admin/partials/dashboard
 */
?>

<div id="webtexttool-login" ng-hide="auth" class="wrap">

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2">

            <div id="post-body-content">

                <div class="postbox">

                    <h3 class="postbox-title">
                        <span>Webtexttool login</span>
                        <img class="webtexttool-logo" ng-src="{{logo}}"
                             alt="Webtexttool"/>
                    </h3>

                    <div class="inside">
                        <p class="description">Use your webtexttool account credentials to log in the form below. <br/>
                            Please note
                            that these are not your WordPress username and password. <br/><br/>
                            If you don't have an account yet, you can easily create one for free <a ng-href="{{WttAppUrl}}register-free" target="_blank"><strong>here</strong></a>.</p>

                        <div ng-if="error != null" class="alert alert-danger" role="alert">
                            <strong>{{error}}</strong>
                        </div>

                        <form class="wtt-form" role="form" name="loginForm">
                            <table class="form-table">
                                <tr>
                                    <td>
                                        <label>E-mail:</label>
                                    </td>
                                    <td><input type="email" name="e-mail" class="regular-text"
                                               placeholder="E-mail"
                                               required="required" ng-model="loginModel.UserName"/>
                                    </td>
                                </tr>
                                <tr class="alternate">
                                    <td>
                                        <label>Password:</label>
                                    </td>
                                    <td><input type="password" name="password" class="regular-text"
                                               placeholder="Password" required="required"
                                               ng-model="loginModel.Password"/></td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="submit" class="button button-primary btn-signin" ng-click="login()"
                                                data-style="expand-left" ladda="loading">
                                            <span class="ladda-label">Sign in</span>
                                            <span class="ladda-spinner"></span>
                                        </button>
                                    </td>
                                    <td>
                                        <a id="forgot-password-link" ng-href="{{WttAppUrl}}forgot" target="_blank">I forgot my password</a>
                                    </td>
                                </tr>
                            </table>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>