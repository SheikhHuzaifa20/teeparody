
<style>
    .myaccount-sidebar {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #eef2f5;
        overflow: hidden;
        margin-bottom: 30px;
    }
    .myaccount-sidebar .sidebar-header {
        background: #006bef;
        color: #ffffff;
        padding: 20px;
        text-align: center;
    }
    .myaccount-sidebar .sidebar-header h5 {
        color: #ffffff;
        margin: 0;
        font-weight: 700;
        font-size: 18px;
    }
    .myaccount-sidebar .myaccount-tab-menu a {
        display: flex;
        align-items: center;
        padding: 14px 20px;
        color: #444;
        font-weight: 600;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .myaccount-sidebar .myaccount-tab-menu a i {
        margin-right: 12px;
        font-size: 16px;
        color: #006bef;
        width: 20px;
        text-align: center;
    }
    .myaccount-sidebar .myaccount-tab-menu a:hover,
    .myaccount-sidebar .myaccount-tab-menu a.active {
        background-color: #006bef;
        color: #ffffff !important;
    }
    .myaccount-sidebar .myaccount-tab-menu a:hover i,
    .myaccount-sidebar .myaccount-tab-menu a.active i {
        color: #ffffff !important;
    }
    .myaccount-sidebar .myaccount-tab-menu a:last-child {
        border-bottom: none;
    }
</style>
<div class="col-lg-3 col-md-4">
    <div class="myaccount-sidebar">
        <div class="sidebar-header">
            <h5><i class="fa fa-user-circle"></i> My Account</h5>
        </div>
        <div class="myaccount-tab-menu nav flex-column" role="tablist">
            <a href="{{ URL('account') }}" class="<?php echo (isset($segment[0]) AND $segment[0] == 'account')  ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ URL('orders') }}" class="<?php echo (isset($segment[0]) AND $segment[0] == 'orders')  ? 'active' : '' ?>">
                <i class="fa fa-shopping-bag"></i> Order History
            </a>
            <a href="{{ URL('account-detail') }}" class="<?php echo (isset($segment[0]) AND $segment[0] == 'account-detail')  ? 'active' : '' ?>">
                <i class="fa fa-user-edit"></i> Account Details
            </a>
            <a href="{{ URL('signout') }}">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</div>
