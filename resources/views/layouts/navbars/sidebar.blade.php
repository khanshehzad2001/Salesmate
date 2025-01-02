<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini"><i class="tim-icons icon-atom"></i></a>
            <a href="#" class="simple-text logo-normal"> {{ _('Salesmate') }}</a>
        </div>
        <ul class="nav">
            <li @if ($pageSlug == 'dashboard') class="active" @endif>
                <a href="{{ route('dashboard.index') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ _('Dashboard') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'customerjourney') class="active" @endif>
                <a href="{{ route('customerjourney.create') }}">
                    <i class="tim-icons icon-user-run"></i>
                    <p>{{ _('Customer Journey') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'products') class="active" @endif>
                <a href="{{ route('product.index')  }}">
                    <i class="tim-icons icon-bag-16"></i>
                    <p>{{ _('Products') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'productdiscovery') class="active" @endif>
                <a href="{{ route('productdiscovery.index')  }}">
                    <i class="tim-icons icon-cart"></i>
                    <p>{{ _('Product Discovery') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'customers') class="active" @endif>
                <a href="{{ route('customer.index') }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ _('Customers') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'customerjourneys') class="active" @endif>
                <a href="{{ route('customerjourney.index') }}">
                    <i class="tim-icons icon-delivery-fast"></i>
                    <p>{{ _("Customer Journeys") }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'profile') class="active" @endif>
                <a href="{{ route('profile.edit')  }}">
                    <i class="tim-icons icon-badge"></i>
                    <p>{{ _('User Profile') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'icons') class="active " @endif hidden>
                <a href="{{ route('pages.icons') }}">
                    <i class="tim-icons icon-atom"></i>
                    <p>{{ _('Icons') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'notifications') class="active " @endif hidden>
                <a href="{{ route('pages.notifications') }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ _('Notifications') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>