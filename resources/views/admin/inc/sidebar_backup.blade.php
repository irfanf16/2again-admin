<div id="sidebar">
    <ul class="nav scroll-color">

        @can('dashboard')
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><a
                    href="{{ route('admin.dashboard') }}"><i class="ico-dashboard"></i>Dashboard</a>
            </li>
        @endcan
        @if(request()->user()->can('app-user-read')  || request()->user()->can('app-reported-user-read') || request()->user()->can('app-banned-user-read') || request()->user()->can('app-deleted-user-read'))
            <li class="dropdown">
                <a href="#"
                   class="dropdown-toggle {{ request()->routeIs('admin.manage.users') || request()->routeIs('admin.manage.users.deleted') ||  request()->routeIs('admin.manage.users.banned') || request()->routeIs('admin.manage.users.detail') || request()->routeIs('admin.manage.users.reports') ? 'show' : '' }}"
                   data-bs-toggle="dropdown"><i class="ico-app_user"></i>App Users</a>
                <ul class="dropdown-menu {{ request()->routeIs('admin.manage.users') || request()->routeIs('admin.manage.users.deleted')  || request()->routeIs('admin.manage.users.banned') || request()->routeIs('admin.manage.users.detail') || request()->routeIs('admin.manage.users.reports') ? 'show' : '' }}">
                    @can('app-user-read')
                        <li class="{{ request()->routeIs('admin.manage.users') || request()->routeIs('admin.manage.users.detail') ? 'active' : '' }}">
                            <a
                                href="{{route('admin.manage.users') }}"><i class="ico-app_user"></i>All Users</a>
                        </li>
                    @endcan
                    @can('app-reported-user-read')
                        <li class="{{ request()->routeIs('admin.manage.users.reports') ? 'active' : '' }}"><a
                                href="{{ route('admin.manage.users.reports') }}"><i class="ico-user_cross"></i>Reported
                                Users</a></li>
                    @endcan
                    @can('app-banned-user-read')
                        <li class="{{ request()->routeIs('admin.manage.users.banned') ? 'active' : '' }}"><a
                                href="{{ route('admin.manage.users.banned') }}"><i class="ico-user_slash"></i>Banned
                                Users</a></li>
                    @endcan
                    @can('app-deleted-user-read')
                        <li class="{{ request()->routeIs('admin.manage.users.deleted') ? 'active' : '' }}"><a
                                href="{{ route('admin.manage.users.deleted') }}"><i class="ico-user_lock"></i>Deleted
                                Users</a></li>
                    @endcan
                </ul>
            </li>
        @endif
        @can('shop-setting-read')
            <li class="{{ request()->routeIs('admin.shop') ? 'active' : '' }}"><a
                    href="{{ route('admin.shop') }}"><i class="ico-cart"></i>Shop</a>
            </li>
        @endcan
        @can('badge-read')
            <li class="{{ request()->routeIs('admin.badges.index') ? 'active' : '' }}"><a
                    href="{{ route('admin.badges.index') }}"><i class="fal ico-badge"></i>Badges</a></li>
        @endcan
        @can('offers-read')
            <li class="{{ request()->routeIs('admin.offers') || request()->routeIs('admin.offers.detail') || request()->routeIs('admin.offers.translation') ? 'active' : '' }}">
                <a
                    href="{{ route('admin.offers') }}"><i
                        class="ico-badge-check"></i>Offers</a></li>
        @endcan

        @if( request()->user()->can('looking-for-read') || request()->user()->can('status-read') || request()->user()->can('subscription-read') || request()->user()->can('app-setting-read') || request()->user()->can('coins-setting-read') || request()->user()->can('dictionary-read') || request()->user()->can('emoji-read') || request()->user()->can('safetyTip-read') || request()->user()->can('country-read')  || request()->user()->can('religion-read'))
            <li class="dropdown">
                <a href="#"
                   class="dropdown-toggle {{  request()->routeIs('admin.looking.translations') || request()->routeIs('admin.looking') ||  request()->routeIs('admin.status.translations') || request()->routeIs('admin.status')  ||  request()->routeIs('admin.religions')  || request()->routeIs('admin.religions.translation') || request()->routeIs('admin.emoji.translation') || request()->routeIs('admin.safety.translation') || request()->routeIs('admin.countries.translation') || request()->routeIs('admin.country') ||  request()->routeIs('admin.safety.index') || request()->routeIs('admin.emoji.detail') || request()->routeIs('admin.dictionary.translations') || request()->routeIs('admin.emoji.index') || request()->routeIs('admin.dictionary') || request()->routeIs('admin.app.settings.coins') || request()->routeIs('admin.app.settings') || request()->routeIs('admin.app.settings.subscriptions') ? 'show' : '' }}"
                   data-bs-toggle="dropdown"><i class="fas fa-cog"></i>Setting</a>
                <ul class="dropdown-menu {{  request()->routeIs('admin.looking.translations') || request()->routeIs('admin.looking') || request()->routeIs('admin.status.translations') || request()->routeIs('admin.status')  || request()->routeIs('admin.religions') || request()->routeIs('admin.religions.translation') || request()->routeIs('admin.emoji.translation') || request()->routeIs('admin.safety.translation') || request()->routeIs('admin.countries.translation') || request()->routeIs('admin.country') || request()->routeIs('admin.safety.index') || request()->routeIs('admin.emoji.detail') || request()->routeIs('admin.dictionary.translations') || request()->routeIs('admin.emoji.index') || request()->routeIs('admin.dictionary') || request()->routeIs('admin.app.settings.coins') || request()->routeIs('admin.app.settings') || request()->routeIs('admin.app.settings.subscriptions') ? 'show' : '' }} ">
                    @can('subscription-read')
                        <li class="{{ request()->routeIs('admin.app.settings.subscriptions') ? 'active' : '' }}"><a
                                href="{{ route('admin.app.settings.subscriptions') }}"><i class="ico-badge_star"></i>Subscriptions</a>
                        </li>
                    @endcan
                    @can('app-setting-read')

                        <li class="{{ request()->routeIs('admin.app.settings') ? 'active' : '' }}"><a
                                href="{{ route('admin.app.settings') }}"><i class="ico-app_setting"></i>App
                                Settings</a>
                        </li>
                    @endcan
                    {{--                    @can('coins-setting-read')--}}

                    {{--                        <li class="{{ request()->routeIs('admin.app.settings.coins') ? 'active' : '' }}"><a--}}
                    {{--                                href="{{ route('admin.app.settings.coins') }}"><i class="fas fa-user-chart"></i>Coin--}}
                    {{--                                Settings</a>--}}
                    {{--                        </li>--}}
                    {{--                    @endcan--}}
                    @can('dictionary-read')

                        <li class="{{ request()->routeIs('admin.dictionary') || request()->routeIs('admin.dictionary.translations') ? 'active' : '' }}">
                            <a
                                href="{{ route('admin.dictionary') }}"><i class="ico-dictionary"></i>Dictionary</a>
                        </li>
                    @endcan
                    @can('emoji-read')

                        <li class="{{ request()->routeIs('admin.emoji.translation') | request()->routeIs('admin.emoji.index') ? 'active' : '' }}">
                            <a
                                href="{{ route('admin.emoji.index') }}"><i class="ico-mood"></i>Daily Mood</a>
                        </li>
                    @endcan
                    @can('safetyTip-read')

                        <li class="{{ request()->routeIs('admin.safety.index') || request()->routeIs('admin.safety.translation')  ? 'active' : '' }}">
                            <a
                                href="{{ route('admin.safety.index') }}"><i class="ico-safety"></i>Safety
                                Tips</a>
                        </li>
                    @endcan
                    @can('country-read')
                        <li class="{{ request()->routeIs('admin.countries.translation') || request()->routeIs('admin.country') ? 'active' : '' }}">
                            <a href="{{route('admin.country')}}"><i class="ico-country"></i>Countries</a></li>
                    @endcan
                    @can('religion-read')
                        <li class="{{ request()->routeIs('admin.religions.translation') || request()->routeIs('admin.religions') ? 'active' : '' }}">
                            <a href="{{route('admin.religions')}}"><i class="ico-religions"></i>Religions</a></li>
                    @endcan
                    @can('status-read')
                        <li class="{{ request()->routeIs('admin.status.translations') || request()->routeIs('admin.status') ? 'active' : '' }}">
                            <a href="{{route('admin.status')}}"><i class="ico-user_status"></i>User Statuses</a></li>
                    @endcan
                    @can('looking-for-read')
                        <li class="{{ request()->routeIs('admin.looking.translations') || request()->routeIs('admin.looking') ? 'active' : '' }}">
                            <a href="{{route('admin.looking')}}"><i class="ico-user_status"></i>Looking For</a></li>
                    @endcan
                </ul>
            </li>
        @endif

        @can('language-read')
            <li class="dropdown">
                <a href="#"
                   class="dropdown-toggle {{ request()->routeIs('admin.response.messages') || request()->routeIs('admin.response.messages.translation') || request()->routeIs('admin.app.translated.languages') || request()->routeIs('admin.languages.translation') || request()->routeIs('admin.languages') ||  request()->routeIs('admin.app.translated.languages.edit') ? 'show' : '' }}"
                   data-bs-toggle="dropdown"><i class="ico-languages"></i>Languages</a>
                <ul class="dropdown-menu {{ request()->routeIs('admin.response.messages') || request()->routeIs('admin.response.messages.translation') || request()->routeIs('admin.app.translated.languages') || request()->routeIs('admin.languages.translation') || request()->routeIs('admin.languages') || request()->routeIs('admin.app.translated.languages.edit') ? 'show' : '' }}">
                    <li class="{{ request()->routeIs('admin.languages.translation') || request()->routeIs('admin.languages') ? 'active' : '' }}">
                        <a href="{{route('admin.languages')}}"><i class="ico-languages"></i>All Languages</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.app.translated.languages') || request()->routeIs('admin.app.translated.languages.edit') ? 'active' : '' }}">
                        <a
                            href="{{ route('admin.app.translated.languages') }}"><i class="ico-app_translate"></i>App
                            Translated Languages</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.response.messages') || request()->routeIs('admin.response.messages.translation') ? 'active' : '' }}">
                        <a
                            href="{{ route('admin.response.messages') }}"><i class="ico-app_translate"></i>Response Messages</a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('giftInvitation-read')
            <li class="dropdown">
                <a href="#"
                   class="dropdown-toggle {{ request()->routeIs('admin.invitation.translation') || request()->routeIs('admin.gifts.translation') || request()->routeIs('admin.gifts') || request()->routeIs('admin.invitations') ? 'show' : '' }}"
                   data-bs-toggle="dropdown"><i class="ico-gift"></i>Gift/Invitations</a>
                <ul class="dropdown-menu {{ request()->routeIs('admin.invitation.translation') || request()->routeIs('admin.gifts.translation') || request()->routeIs('admin.gifts') || request()->routeIs('admin.invitations') ? 'show' : '' }}">
                    <li class="{{ request()->routeIs('admin.gifts.translation') || request()->routeIs('admin.gifts') ? 'active' : '' }}">
                        <a
                            href="{{ route('admin.gifts') }}"><i class="ico-gift"></i>Gifts</a>
                    </li>
                    <li class="{{  request()->routeIs('admin.invitation.translation') || request()->routeIs('admin.invitations') ? 'active' : '' }}">
                        <a
                            href="{{ route('admin.invitations') }}"><i class="ico-invitation"></i>Invitations</a>
                    </li>

                </ul>
            </li>
        @endcan
        @can('faqs-read')
            <li class="dropdown">
                <a href="#"
                   class="dropdown-toggle {{ request()->routeIs('admin.faqsType.translation') || request()->routeIs('admin.faqs.translation') || request()->routeIs('admin.faqsType') || request()->routeIs('admin.faqs') ? 'show' : '' }}"
                   data-bs-toggle="dropdown"><i class="ico-faqs"></i>FAQs</a>
                <ul class="dropdown-menu {{ request()->routeIs('admin.faqsType.translation') || request()->routeIs('admin.faqs.translation') || request()->routeIs('admin.faqsType') || request()->routeIs('admin.faqs') ? 'show' : '' }}">
                    <li class="{{ request()->routeIs('admin.faqsType.translation') || request()->routeIs('admin.faqsType') ? 'active' : '' }}">
                        <a
                            href="{{ route('admin.faqsType') }}"><i class="ico-faqs_type"></i>FAQs Types</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.faqs.translation') || request()->routeIs('admin.faqs') ? 'active' : '' }}">
                        <a
                            href="{{ route('admin.faqs') }}"><i class="ico-faqs"></i>FAQs</a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('crowdfunding-read')
            <li class="dropdown">
                <a href="#"
                   class="dropdown-toggle {{ request()->routeIs('admin.companies') || request()->routeIs('admin.vouchers') ? 'show' : '' }}"
                   data-bs-toggle="dropdown"><i class="ico-crowd_fund"></i>Crowd Funding</a>
                <ul class="dropdown-menu {{ request()->routeIs('admin.companies') || request()->routeIs('admin.vouchers') ? 'show' : '' }}">
                    <li class="{{ request()->routeIs('admin.companies') ? 'active' : '' }}"><a
                            href="{{ route('admin.companies') }}"><i class="ico-company"></i>Companies</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.vouchers') ? 'active' : '' }}"><a
                            href="{{ route('admin.vouchers') }}"><i class="ico-voucher"></i>Vouchers</a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('otherApp-read')
            <li class="dropdown">
                <a href="#"
                   class="dropdown-toggle {{ request()->routeIs('admin.otherApps.edit') || request()->routeIs('admin.otherApps.add') || request()->routeIs('admin.otherApps') || request()->routeIs('admin.otherApps.companies') ? 'show' : '' }}"
                   data-bs-toggle="dropdown"><i class="ico-other_app"></i>Other Apps</a>
                <ul class="dropdown-menu {{ request()->routeIs('admin.otherApps.edit') || request()->routeIs('admin.otherApps.add') || request()->routeIs('admin.otherApps.companies') || request()->routeIs('admin.otherApps') ? 'show' : '' }}">
                    <li class="{{ request()->routeIs('admin.otherApps.companies') ? 'active' : '' }}"><a
                            href="{{ route('admin.otherApps.companies') }}"><i
                                class="ico-company"></i>Companies</a>
                    </li>
                    <li class="{{  request()->routeIs('admin.otherApps.edit') || request()->routeIs('admin.otherApps.add') || request()->routeIs('admin.otherApps') ? 'active' : '' }}">
                        <a
                            href="{{ route('admin.otherApps') }}"><i class="ico-other_app"></i>Apps</a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('purchase-read')
            <li class="{{ request()->routeIs('admin.purchases') ? 'active' : '' }}"><a
                    href="{{ route('admin.purchases') }}"><i class="ico-purchase"></i>Purchases</a></li>
        @endcan
        @can('withdrawal-request-read')
            <li class="{{ request()->routeIs('admin.withdrawal') || request()->routeIs('admin.withdrawal.detail') ? 'active' : '' }}">
                <a href="{{route('admin.withdrawal')}}"><i class="ico-app_download"></i>Withdrawal Request</a></li>
        @endcan
        @can('support-email-read')
            <li class="{{ request()->routeIs('admin.support') ? 'active' : '' }}"><a
                    href="{{route('admin.support')}}"><i
                        class="ico-support_mail"></i>Support Email</a></li>
        @endcan
        @can('pre-registration')
            <li class="{{ request()->routeIs('admin.subscribers') ? 'active' : '' }}"><a
                    href="{{route('admin.subscribers')}}"><i
                        class="ico-support_mail"></i>Pre-Registration</a>
            </li>
        @endcan
        @can('contact-us')
            <li class="{{ request()->routeIs('admin.contact') ? 'active' : '' }}"><a
                    href="{{route('admin.contact')}}"><i
                        class="ico-support_mail"></i>Contact Us</a></li>
        @endcan
        @can('notification-read')
            <li class="dropdown">
                <a href="#"
                   class="dropdown-toggle {{ request()->routeIs('admin.custom.notification') || request()->routeIs('admin.app.notification')  ? 'show' : ''}}"
                   data-bs-toggle="dropdown"><i class="fal ico-bell"></i>Notifications</a>
                <ul class="dropdown-menu {{ request()->routeIs('admin.custom.notification')  || request()->routeIs('admin.app.notification') ? 'show' : ''}}">
                    <li class="{{ request()->routeIs('admin.custom.notification')  ? 'active' : '' }}">
                        <a
                            href="{{ route('admin.custom.notification') }}"><i class="fal ico-bell"></i>Custom
                            Notifications</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.app.notification')  ? 'active' : '' }}">
                        <a
                            href="{{ route('admin.app.notification') }}"><i class="fal ico-bell"></i>Abusive
                            Notifications</a>
                    </li>

                </ul>
            </li>

        @endcan
        @can('system-user-read')
            <li class="{{ request()->routeIs('admin.system.users') || request()->routeIs('admin.system.users.edit')  ? 'active' : '' }}">
                <a href="{{route('admin.system.users')}}"><i class="ico-app_user"></i>System Users</a></li>
        @endcan
        @can('rolePermissions')
            <li class="dropdown">
                <a href="#"
                   class="dropdown-toggle {{ request()->routeIs('admin.roles') || request()->routeIs('admin.roles.create') || request()->routeIs('admin.roles.edit') || request()->routeIs('admin.permissions') ? 'show' : '' }}"
                   data-bs-toggle="dropdown"><i class="ico-user_lock"></i>Roles & Permissions</a>
                <ul class="dropdown-menu {{ request()->routeIs('admin.roles') || request()->routeIs('admin.roles.create') || request()->routeIs('admin.roles.edit') || request()->routeIs('admin.permissions') ? 'show' : '' }}">
                    <li class="{{ request()->routeIs('admin.roles') || request()->routeIs('admin.roles.create') || request()->routeIs('admin.roles.edit')  ? 'active' : '' }}">
                        <a
                            href="{{ route('admin.roles') }}"><i class="ico-user_role"></i>Roles</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.permissions') ? 'active' : '' }}"><a
                            href="{{ route('admin.permissions') }}"><i class="ico-permission"></i>Permissions</a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('legal-read')
            <li class="dropdown">
                <a href="#"
                   class="dropdown-toggle {{ request()->routeIs('admin.consent') || request()->routeIs('admin.GDPR.view') || request()->routeIs('admin.GDPR') || request()->routeIs('admin.terms') || request()->routeIs('admin.privacy') ? 'show' : '' }}"
                   data-bs-toggle="dropdown"><i class="ico-legal"></i>Legal</a>
                <ul class="dropdown-menu {{ request()->routeIs('admin.consent') || request()->routeIs('admin.GDPR.view') || request()->routeIs('admin.GDPR') || request()->routeIs('admin.terms') || request()->routeIs('admin.privacy') ? 'show' : '' }}">
                    <li class="{{ request()->routeIs('admin.terms')  ? 'active' : '' }}"><a
                            href="{{ route('admin.terms') }}"><i class="ico-terms_use"></i>Terms of Use</a>
                    </li>
                    <li class="{{  request()->routeIs('admin.privacy') ? 'active' : '' }}"><a
                            href="{{ route('admin.privacy') }}"><i class="ico-privacy_policy"></i>Privacy Policy</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.GDPR.view') || request()->routeIs('admin.GDPR') ? 'active' : '' }}">
                        <a
                            href="{{ route('admin.GDPR') }}"><i class="ico-privacy_policy"></i>GDPR</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.consent')  ? 'active' : '' }}">
                        <a
                            href="{{ route('admin.consent') }}"><i class="ico-privacy_policy"></i>Consent</a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('reporting')
            <li><a href="javascript:void(0)" onclick="alert('Not working yet')"><i
                        class="ico-reportin"></i>Reporting</a></li>
            {{--            <li><a href="{{route('admin.reporting')}}"><i class="fal ico-badge"></i>Reporting</a></li>--}}
        @endcan
            @can('app-version-control')
            <li class="{{ request()->routeIs('admin.app.versions')  ? 'active' : '' }}"><a href="{{route('admin.app.versions')}}"><i
                        class="ico-reportin"></i>App Version</a></li>
            @endcan
    </ul>
</div>
