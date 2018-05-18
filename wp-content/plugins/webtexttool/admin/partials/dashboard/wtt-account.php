<div id="wtt-account" ng-show="auth" class="wrap"
     cg-busy="{promise:accountPromise,message:promiseMessage,backdrop:true,templateUrl:promiseTemplate}">

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2">

            <div id="post-body-content">

                <div class="postbox">

                    <h3 class="postbox-title">
                        <span>Webtexttool dashboard</span>
                        <img class="webtexttool-logo"
                             src="<?php echo plugins_url('../images/wtt_logo.png', dirname(__FILE__)); ?>"
                             alt="Webtexttool"/>
                    </h3>

                    <div class="inside">

                        <h3 class="wtt_view_title">Thank you for using webtexttool to analyze, optimize and
                            monitor your content.</h3>
                        <hr class="wtt-hr">

                        <div id="wtt_dashboard_body">

                            <div id="wtt-plans">
                                <div class="inside account-summary">

                                    <div class="wtt-plan">
                                        <h3 class="wtt-plan-title">Account details for
                                            <strong>{{userInfo.UserName}}</strong>:</h3>
                                        <ul class="plan-details">
                                            <li class="plan-item">
                                                <span class="value-no">{{userInfo.SubscriptionName}}</span>
                                                <span class="value-label">Plan subscription</span>
                                            </li>
                                            <li class="plan-item">
                                                <span class="value-no">{{userInfo.Credits}}</span>
                                                <span class="value-label">Keyword credits this month</span>
                                            </li>
                                            <li class="plan-item">
                                                <span class="value-no">{{userInfo.AvailablePageTrackers}}</span>
                                                <span class="value-label">Pagetrackers available</span>
                                            </li>
                                            <li class="plan-item" ng-show="userInfo.UserState == 3">
                                                <span class="value-no">{{displayTrialDays(userInfo.TrialDays)}}</span>
                                                <span class="value-label">Remaining trial days</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="subscription-button" ng-show="userInfo.CanUpgrade">
                                        <a class="subscription-label subscription-label-orange"
                                           ng-href="{{WttAppUrl}}app/account/upgrade?tab=subscriptions"
                                           target="_blank">Upgrade your account</a>
                                    </div>
                                </div>
                            </div>

                            <hr class="wtt-hr">

                            <div class="account-options">
                                <ul class="fa-ul">
                                    <li><i class="fa-li fa fa-user"></i><a
                                                ng-href="{{WttAppUrl}}app/account?tab=account"
                                                target="_blank">My Account</a></li>
                                    <li><i class="fa-li fa fa-check-square-o"></i><a
                                                ng-href="{{WttAppUrl}}app/account?tab=subscriptions"
                                                target="_blank">Subscriptions</a></li>
                                    <li><i class="fa-li fa fa-key"></i><a
                                                ng-href="{{WttAppUrl}}app/account?tab=changePassword"
                                                target="_blank">Change your password</a></li>
                                    <li><i class="fa-li fa fa-exchange"></i><a
                                                ng-href="{{WttAppUrl}}app/account?tab=transactions"
                                                target="_blank">Transactions overview</a></li>
                                </ul>
                            </div>

                            <hr class="wtt-hr">

                            <div id="wtt_settings_submit">
                                <button type="submit" class="button button-primary" ng-click="logout()"
                                        data-style="expand-left" ladda="loading">
                                    <span class="ladda-label">Sign out</span>
                                    <span class="ladda-spinner"></span>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="wtt_helpaccountside" class="wtt_helpside">
        <div>
            <span class="wtt_title">FAQs</span>
            <ul>
                <li>
                    <a ng-href="{{WttAppUrl}}app/help/details/question/da283826-073b-422b-b2e7-1a5d2ec6b089"
                       target="_blank">What is webtexttool?</a></li>
                <li>
                    <a ng-href="{{WttAppUrl}}app/help/details/question/ca3ffac3-134c-4238-88d7-092aff41e2d2"
                       target="_blank">What is the advantage of using webtexttool?</a></li>
                <li>
                    <a ng-href="{{WttAppUrl}}app/help/details/question/47c46555-1da3-420f-a51f-4532ae613365"
                       target="_blank">Is my text 100% optimized if I use webtexttool?</a></li>
                <li>
                    <a ng-href="{{WttAppUrl}}app/help/details/question/10db224c-ccfc-4a13-a7bf-c45af6f595a6"
                       target="_blank">Video: How does webtexttool work?</a></li>
            </ul>
        </div>
    </div>
</div>