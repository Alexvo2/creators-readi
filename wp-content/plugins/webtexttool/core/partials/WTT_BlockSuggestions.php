<div class="wtt_box" ng-show="auth" style="clear: both">
    <div id="wtt_blockseo" ng-class="{}">
        <div class="wtt_header">SEO Realtime Suggestions
            <button popover-placement="auto top" popover-trigger="outsideClick" uib-wtt-popover-html="htmlPopoverS"
                    type="button" class="btn-info-s">
                <i class="fa fa-question-circle"></i>
            </button>
        </div>
        <aside class="sidebar display-block"
               ng-show="isCollapsed">

            <div class="page-info" ng-cloak>
                <label class="sub-label">Keyword:</label>
                <div class="keyBox" ng-click="isCollapsed = !isCollapsed">
                    <span class="keyword">{{Keyword}}</span>
                </div>

                <div class="wtt-menu-right">
                    <ul class="list-inline list-unstyled">
                        <li>
                            <div class="btn-group">
                                <button type="button" class="btn btn-icon dropdown-toggle btn-settings"
                                        data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-custom">
                                    <li>
                                    <span class="menu-check">
                                        <a href="javascript:;" ng-click="processTitleAsH1Click()">
                                            <input id="process-title-as-h1" type="checkbox"
                                                   ng-model="checkboxModel.isChecked">
                                        </a>
                                    </span>
                                        <span>Process page title as H1</span>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="btn-group btn-group-custom" ng-show="isCollapsed">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"><i class="flag flag-{{activeLanguageCode}}"></i><span
                                            class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-custom">
                                    <li ng-repeat="language in languages"
                                        ng-class="{active: language.LanguageCode == activeLanguageCode}"><a
                                                href="javascript:;"
                                                ng-click="setActiveLanguage(language)"><i
                                                    class="flag flag-{{language.LanguageCode}}"></i>
                                            {{language.LanguageName}}</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="wtt-tabs-container" style="display: flow-root;" ng-show="isCollapsed">
                <div class="wtt-sidebar-tab-menu">
                    <ul class="wtt-nav wtt-nav-tabs" role="tablist">
                        <li ng-class="{'active':activeEngine=='seo'}"><a href="javascript:;"
                                                                         ng-click="selectEngine('seo')">SEO</a>
                        </li>
                        <li ng-class="{'active':activeEngine=='content'}"><a href="javascript:;"
                                                                             ng-click="selectEngine('content')">CONTENT</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="wtt-tbl wtt-page-score-area" ng-cloak>

                <div class="sk-circle" ng-show="loading">
                    <div class="sk-circle1 sk-child"></div>
                    <div class="sk-circle2 sk-child"></div>
                    <div class="sk-circle3 sk-child"></div>
                    <div class="sk-circle4 sk-child"></div>
                    <div class="sk-circle5 sk-child"></div>
                    <div class="sk-circle6 sk-child"></div>
                    <div class="sk-circle7 sk-child"></div>
                    <div class="sk-circle8 sk-child"></div>
                    <div class="sk-circle9 sk-child"></div>
                    <div class="sk-circle10 sk-child"></div>
                    <div class="sk-circle11 sk-child"></div>
                    <div class="sk-circle12 sk-child"></div>
                </div>

                <div class="wtt-tbl-cell" id="wtt-page-score-container" ng-show="showScore">
                    <div ng-class="seoClass" id="wtt-page-score" title="{{seoScoreTag}}">
                        <input class="wtt-page-score-text" id="wtt-page-score-input" name="wtt_page_score_field"
                               type="text"
                               ng-value="seoScore">
                        <canvas tc-chartjs-doughnut chart-data="seoPageScoreData"
                                chart-options="pageScoreChartOptions" width="110" height="110"></canvas>
                    </div>
                </div>

                <div class="wtt-tbl-cell" ng-show="showScore">
                    <div ng-class="contentClass" id="wtt-content-score" title="{{contentScoreTag}}">
                        <input class="wtt-content-score-text" id="wtt-content-score-input" type="text" ng-value="contentScore">
                        <canvas tc-chartjs-doughnut chart-data="contentPageScoreData"
                                chart-options="pageScoreChartOptions" width="110" height="110"></canvas>
                    </div>
                </div>

                <div class="wtt-tbl-cell wtt-score-error" ng-show="showError">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i><br/>{{error}}
                </div>

            </div>

            <div class="suggestions-mask seo" id="suggestionsContainer" ng-show="activeEngine == 'seo'">

                <div class="suggestions">
                    <wtt-suggestion ng-repeat="suggestion in suggestions"
                                    suggestion="suggestion"
                                    index="{{$index}}"></wtt-suggestion>
                </div>
            </div>

            <wtt-content-quality ng-show="activeEngine == 'content'"></wtt-content-quality>

        </aside>
    </div>
</div>