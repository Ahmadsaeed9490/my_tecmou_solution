<div class="sidebar pb-3">
    <nav class="navbar navbar-light">
        <a href="{{ route('dashboard') }}" class="navbar-brand ms-3" style="font-size: 40px; margin-right: 30px;">
            <img src="{{asset('assets/img/logo1.png')}}" alt=""> </a>
        <div class="navbar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item nav-link active text-center border-top">
                <i class="bi bi-grid"></i>
                <p class="pt-1 mb-0">Dashboard</p>
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-item nav-link  text-center border-top">
            <i class="bi bi-person"></i>
                <p class="pt-1 mb-0">User</p>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="nav-item nav-link  text-center border-top">
                <i class="bi bi-bookmarks-fill"></i>
                <p class="pt-1 mb-0">
                    <p class="pt-1 mb-0">Category</p>
                </p>
            </a>


            <a href="{{ route('admin.brands.index') }}" class="nav-item nav-link  text-center border-top">
                <i class="bi bi-tag-fill"></i>
                <p class="pt-1 mb-0">
                    <p class="pt-1 mb-0">Brands</p>
                </p>
            </a>

             <a href="{{ route('admin.products.index') }}" class="nav-item nav-link  text-center border-top">
              <i class="bi bi-cart"></i>	
                <p class="pt-1 mb-0">
                    <p class="pt-1 mb-0">products</p>
                </p>
            </a>

            <div id="navbar-toggler3" class="nav-item nav-link text-center">
                <i class="bi bi-file-earmark-text"></i>
                <p class="pt-1 mb-0">Purchase</p>
            </div>
            <div id="navbar-toggler4" class="nav-item nav-link text-center">
                <i class="bi bi-bag"></i>
                <p class="pt-1 mb-0">Inventory</p>
            </div>
            <div id="navbar-toggler5" class="nav-item nav-link text-center">
                <i class="bi bi-arrow-90deg-left"></i>
                <p class="pt-1 mb-0">Transfer</p>
            </div>
            <div id="navbar-toggler6" class="nav-item nav-link text-center">
                <i class="fa-solid fa-wallet"></i>
                <p class="pt-1 mb-0">Accounting</p>
            </div>
            <div id="navbar-toggler7" class="nav-item nav-link text-center">
                <i class="bi bi-person"></i>
                <p class="pt-1 mb-0">Customer</p>
            </div>
            <div id="navbar-toggler8" class="nav-item nav-link text-center">
                <i class="bi bi-house"></i>
                <p class="pt-1 mb-0">Vendors</p>
            </div>
            <div id="navbar-toggler9" class="nav-item nav-link text-center">
                <i class="bi bi-clipboard-data"></i>
                <p class="pt-1 mb-0">Report</p>
            </div>
            <a href="shipment.html" class="nav-item nav-link text-center">
                <i class="bi bi-clipboard-data"></i>
                <p class="pt-1 mb-0">Shipment</p>
            </a>
            <a href="customermanagement.html" class="nav-item nav-link text-center">
                <i class="bi bi-clipboard-data"></i>
                <p class="pt-1 mb-0">Add Module</p>
            </a>
            <div id="navbar-toggler10" class="nav-item nav-link text-center">
                <i class="bi bi-gear"></i>
                <p class="pt-1 mb-0">Setting</p>
            </div>
        </div>
    </nav>
</div>

<div class="positon-relative sidebar-ul">
    <div id="product" style="display: none">
        <ul class="list-unstyled m-0 px-4 rounded-5">
            <li>
                <a href="" class="text-decoration-none nav-item nav-link"><img src="{{ asset('assets/img/menu.svg') }}"
                        class="img-fluid me-2" alt="" />All Product</a>
            </li>
            <li class="mb-2">
                <a href="" class="text-decoration-none nav-item nav-link"><img src="{{ asset('assets/img/menu.svg') }}"
                        class="img-fluid me-2" alt="" />Create
                    Product</a>
            </li>
            <li class="mb-2">
                <a href="" class="text-decoration-none nav-item nav-link"><img src="{{ asset('assets/img/menu.svg') }}"
                        class="img-fluid me-2" alt="" />Category</a>
            </li>
            <li class="mb-2">
                <a href="" class="text-decoration-none nav-item nav-link"><img src="{{ asset('assets/img/menu.svg') }}"
                        class="img-fluid me-2" alt="" />Brand</a>
            </li>
            <li class="mb-2">
                <a href="unit.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Unit</a>
            </li>
        </ul>
    </div>
    <div id="sale" style="display: none">
        <ul class="list-unstyled m-0 py-3 px-4 rounded-5">
            <li class="mb-2">
                <a href="sale.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />All Sale</a>
            </li>
            <li class="mb-2">
                <a href="createsale.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Create Sale</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Create Sale
                    Order</a>
            </li>
            <li class="mb-2">
                <a href="pos.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />POS</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Create Sale
                    Return</a>
            </li>
        </ul>
    </div>
    <div id="purchase" style="display: none">
        <ul class="list-unstyled m-0 py-3 px-4 rounded-5">
            <li class="mb-2">
                <a href="purchase.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />All Purchase</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Create
                    Purchase</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Create Purchase
                    Order</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Create Purchase
                    Return</a>
            </li>
        </ul>
    </div>
    <div id="inventory" style="display: none">
        <ul class="list-unstyled m-0 py-3 px-4 rounded-5">
            <li class="mb-2">
                <a href="inventory.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />All Inventory</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Recieve
                    Inventory</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Create Bill</a>
            </li>
        </ul>
    </div>
    <div id="transfer" style="display: none">
        <ul class="list-unstyled m-0 py-3 px-4 rounded-5">
            <li class="mb-2">
                <a href="alltransfer.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />All Transfer</a>
            </li>
            <li class="mb-2">
                <a href="createtransfer.html" class="text-decoration-none nav-item nav-link"><img
                        src="assets/img/menu.svg" class="img-fluid me-2" alt="" />Create
                    Transfer</a>
            </li>
        </ul>
    </div>
    <div id="accounting" style="display: none">
        <ul class="list-unstyled m-0 py-3 px-4 rounded-5">
            <li class="mb-2">
                <a href="listaccount.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />List Accounts</a>
            </li>
            <li class="mb-2">
                <a href="transfermoney.html" class="text-decoration-none nav-item nav-link"><img
                        src="assets/img/menu.svg" class="img-fluid me-2" alt="" />Transfer
                    Money</a>
            </li>
            <li class="mb-2">
                <a href="createexpense.html" class="text-decoration-none nav-item nav-link"><img
                        src="assets/img/menu.svg" class="img-fluid me-2" alt="" />Create
                    Expense</a>
            </li>
            <li class="mb-2">
                <a href="allexpense.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />All Expense</a>
            </li>
            <li class="mb-2">
                <a href="createdeposit.html" class="text-decoration-none nav-item nav-link"><img
                        src="assets/img/menu.svg" class="img-fluid me-2" alt="" />Create
                    Deposit</a>
            </li>
            <li class="mb-2">
                <a href="listdeposit.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />List Deposit</a>
            </li>
            <li class="mb-2">
                <a href="expensecategory.html" class="text-decoration-none nav-item nav-link"><img
                        src="assets/img/menu.svg" class="img-fluid me-2" alt="" />Expense
                    Category</a>
            </li>
            <li class="mb-2">
                <a href="depositcategory.html" class="text-decoration-none nav-item nav-link"><img
                        src="assets/img/menu.svg" class="img-fluid me-2" alt="" />Deposit
                    Category</a>
            </li>
        </ul>
    </div>
    <div id="customer" style="display: none">
        <ul class="list-unstyled m-0 py-3 px-4 rounded-5">
            <li class="mb-2">
                <a href="customer.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />All Customer</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Create
                    Customer</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Blacklist
                    Customer</a>
            </li>
        </ul>
    </div>
    <div id="vendor" style="display: none">
        <ul class="list-unstyled m-0 py-3 px-4 rounded-5">
            <li class="mb-2">
                <a href="vendor.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />All Vendor</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Create Vendors
                </a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Blacklist
                    Vendors</a>
            </li>
        </ul>
    </div>
    <div id="report" style="display: none">
        <ul class="list-unstyled m-0 py-3 px-4 rounded-5">
            <li class="mb-2">
                <a href="report.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />All Report</a>
            </li>
            <li class="mb-2">
                <a href="warehousereport.html" class="text-decoration-none nav-item nav-link"><img
                        src="assets/img/menu.svg" class="img-fluid me-2" alt="" />Warehouse
                    Report</a>
            </li>
        </ul>
    </div>
    <div id="setting" style="display: none">
        <ul class="list-unstyled m-0 py-3 px-4 rounded-5">
            <li class="mb-2">
                <a href="setting.html" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />System
                    Setting</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />User
                    Permission</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />SMS Setting</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Email Setting</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />POS Setting</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Payment
                    Setting</a>
            </li>
            <li class="mb-2">
                <a href="#" class="text-decoration-none nav-item nav-link"><img src="assets/img/menu.svg"
                        class="img-fluid me-2" alt="" />Tax Setting</a>
            </li>
        </ul>
    </div>
</div>