@extends('layout.master')
@section('content')
<div class="container-fluid px-4">
  <div class="row">
      <div class="col-md-6 mt-4">
          <div class="card border-0 h-100 card-shadow p-3">
              <div class="row align-items-center">
                  <div class="col-md-7">
                    <h4 id="greeting" class="mb-0 mt-2 heading text-start card-title">
                      Good Morning,
                    </h4>                  
                      <p>Here’s what happening with your store today!</p>
                      <div class="mt-4">
                          <h6 class="mb-0 sales-amount text-dark">$1040.00</h6>
                          <p>Today's Total Purchases</p>
                      </div>
                      <div class="mt-4">
                          <h6 class="mb-0 sales-amount text-dark">$341.00</h6>
                          <p>Today's Total Sales</p>
                      </div>
                  </div>
                  <div class="col-md-5">
                      <img src="{{ asset('assets/img/overview.png') }}" class="img-fluid" alt="" />
                  </div>
              </div>
          </div>
      </div>
      <div class="col-md-6 mt-4">
          <div class="row">
              <div class="col-md-6 mt-4">
                  <a href="sale.html" class="text-decoration-none">
                      <div class="card-shadow border rounded d-flex align-items-center p-3">
                          <img src="{{ asset('assets/img/content-sale.svg') }}" class="img-fluid text-center"
                              alt="" />
                          <div class="ms-3">
                              <p class="mb-1 fs-6 text-muted subheading">Sale</p>
                              <h6 class="mb-0 sales-amount">1000$</h6>
                          </div>
                      </div>
                  </a>
              </div>
              <div class="col-md-6 mt-4">
                  <a href="purchase.html" class="text-decoration-none">
                      <div class="card-shadow border rounded d-flex align-items-center p-3">
                          <img src="{{ asset('assets/img/content-bag.svg') }}" class="img-fluid text-center"
                              alt="" />
                          <div class="ms-3">
                              <p class="mb-1 text-muted subheading">Purchase</p>
                              <h6 class="mb-0 sales-amount">1000$</h6>
                          </div>
                      </div>
                  </a>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6 mt-4">
                  <a href="#" class="text-decoration-none">
                      <div class="card-shadow border rounded d-flex align-items-center p-3">
                          <img src="{{ asset('assets/img/content-right-arrow.svg') }}" class="img-fluid text-center"
                              alt="" />
                          <div class="ms-3">
                              <p class="mb-1 fs-6 text-muted subheading">
                                  Sales Return
                              </p>
                              <h6 class="mb-0 sales-amount">1000$</h6>
                          </div>
                      </div>
                  </a>
              </div>
              <div class="col-md-6 mt-4">
                  <a href="#" class="text-decoration-none">
                      <div class="card-shadow border rounded d-flex align-items-center p-3">
                          <img src="{{ asset('assets/img/content-left-arrow.svg') }}" class="img-fluid text-center"
                              alt="" />
                          <div class="ms-3">
                              <p class="mb-1 fs-6 text-muted subheading">
                                  Purchase Return
                              </p>
                              <h6 class="mb-0 sales-amount">1000$</h6>
                          </div>
                      </div>
                  </a>
              </div>
          </div>
      </div>
  </div>

<div class="container-fluid px-4">
  <div class="row mt-2">
      <div class="col-md-7 col-12 mt-4">
          <div class="card-shadow text-center rounded p-4 card border-0 h-100">
              <div class="row card-header border-0 bg-white">
                  <div class="col-md-6 col-12">
                      <h4 class="mb-0 mt-2 heading text-start card-title">
                          Sale and Purchase
                      </h4>
                  </div>
                  <div class="col-md-6 col-12 d-flex flex-wrap text-end justify-content-end">
                      <span class="calendar-icon rounded-3 me-1">Today</span>
                      <img src="{{ asset('assets/img/calendar.svg') }}" class="calendar-icon rounded-3 me-1"
                          alt="" data-bs-toggle="modal" data-bs-target="#myModal"
                          style="cursor: pointer" />
                      <div class="calendar-icon fs-6 me-2 rounded-3 chart-days">
                          <span class="me-1">1D</span>
                          <span class="me-1">1W</span>
                          <span class="me-1">1M</span>
                          <span class="bg-purple text-white badge text-center">1Y</span>
                      </div>
                  </div>
              </div>
              <div class="card-body h-100">
                  <canvas id="barChart" class="dashboard-chart"></canvas>
              </div>
          </div>
      </div>
      <div class="col-12 col-md-5 mt-4">
          <div class="card-shadow rounded p-4 px-3 w-100 card border-0 h-100">
              <div class="card-header bg-white p-0 m-0 d-flex justify-content-between">
                  <h5 class="text-start mt-2 pb-2 heading ps-3">
                      This Month top selling Products
                  </h5>
                  <img src="{{ asset('assets/img/help-icon.svg') }}" class="img-fluid" alt="" />
              </div>
              <div class="card-body h-100 px-0">
                  <div class="table-responsive">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th class="text-secondary">Code</th>
                                  <th class="text-secondary">Product</th>
                                  <th class="text-secondary">Warehouse</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td>1102324</td>
                                  <td>Product</td>
                                  <td>12</td>
                              </tr>
                              <tr>
                                  <td>1102324</td>
                                  <td>Product</td>
                                  <td>12</td>
                              </tr>
                              <tr>
                                  <td>1102324</td>
                                  <td>Product</td>
                                  <td>12</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
              <div class="card-footer bg-white border-0 h-100 text-end">
                  <div class="row align-items-center text-end justify-content-end">
                      <div class="col-auto">
                          <p class="subheading col-form-label">1-3 of 15 entries</p>
                      </div>
                      <div class="col-auto">
                          <div class="new-pagination">
                              <a href="#" class="rounded-start">❮</a>
                              <a href="#" class="rounded-end">❯</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- Sales Chart End -->

<!-- Recent Sales Start -->
<div class="container-fluid px-4">
  <div class="row mt-2">
      <div class="col-md-7 text-center mt-4">
          <div class="card-shadow card p-3 rounded-3 border-0 h-100">
              <div class="card-header bg-white p-0 m-0 mb-2">
                  <h5 class="text-start ps-3 mt-2 pb-2 heading">Stock Alert</h5>
              </div>
              <div class="card-body p-0 m-0">
                  <div class="table-responsive">
                      <table class="table text-start">
                          <thead>
                              <tr>
                                  <th class="text-secondary">Code</th>
                                  <th class="text-secondary">Product</th>
                                  <th class="text-secondary">Warehouse</th>
                                  <th class="text-secondary">Quantity</th>
                                  <th class="text-secondary">Alert Quantity</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td>1102324</td>
                                  <td>Product</td>
                                  <td>Warehouse</td>
                                  <td>12</td>
                                  <td>
                                      <span class="badges bg-lightred text-center">24</span>
                                  </td>
                              </tr>
                              <tr>
                                  <td>1102324</td>
                                  <td>Product</td>
                                  <td>Warehouse</td>
                                  <td>12</td>
                                  <td>
                                      <span class="badges bg-lightred text-center">24</span>
                                  </td>
                              </tr>
                              <tr>
                                  <td>1102324</td>
                                  <td>Product</td>
                                  <td>Warehouse</td>
                                  <td>12</td>
                                  <td>
                                      <span class="badges bg-lightred text-center">24</span>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
              <div class="card-footer border-0 bg-white p-0 m-0">
                  <div class="row align-items-center text-end justify-content-end">
                      <div class="col-auto">
                          <p class="subheading col-form-label">1-4 of 15 entries</p>
                      </div>
                      <div class="col-auto">
                          <div class="new-pagination">
                              <a href="#" class="rounded-start">❮</a>
                              <a href="#" class="rounded-end">❯</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-md-5 text-center mt-4">
          <div class="card-shadow p-3 rounded-3 card border-0 h-100">
              <div class="card-header bg-white p-0 m-0">
                  <h5 class="text-start ps-3 mt-2 pb-2 heading">
                      Top Customers for the month
                  </h5>
              </div>
              <div class="card-body p-0 m-0">
                  <div class="table-responsive text-center">
                      <table class="table text-start">
                          <thead>
                              <tr>
                                  <th class="text-secondary">Code</th>
                                  <th class="text-secondary">Product</th>
                                  <th class="text-secondary">Warehouse</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td>1102324</td>
                                  <td>Product</td>
                                  <td>Warehouse</td>
                              </tr>
                              <tr>
                                  <td>1102324</td>
                                  <td>Product</td>
                                  <td>Warehouse</td>
                              </tr>
                              <tr>
                                  <td>1102324</td>
                                  <td>Product</td>
                                  <td>Warehouse</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
              <div class="card-footer border-0 bg-white p-0 m-0">
                  <div class="row align-items-center text-end justify-content-end">
                      <div class="col-auto">
                          <p class="subheading col-form-label">1-4 of 15 entries</p>
                      </div>
                      <div class="col-auto">
                          <div class="new-pagination">
                              <a href="#" class="rounded-start">❮</a>
                              <a href="#" class="rounded-end">❯</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

<div class="container-fluid pt-4 px-4 mt-3 mb-5">
  <div class="card border-0 card-shadow p-3 rounded-3">
      <div class="card-header bg-white p-0 m-0">
          <h5 class="text-start ps-3 mt-2 pb-1 heading">
              Recent Transactions
          </h5>
      </div>
      <div class="card-body p-0 m-0 mt-2">
          <div class="table-responsive text-center">
              <table class="table text-start">
                  <thead>
                      <tr>
                          <th class="text-secondary">Reference</th>
                          <th class="text-secondary">Customer</th>
                          <th class="text-secondary">Warehouse</th>
                          <th class="text-secondary">Status</th>
                          <th class="text-secondary">Grand Total</th>
                          <th class="text-secondary">Paid</th>
                          <th class="text-secondary">Due</th>
                          <th class="text-secondary">Payment Status</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>SL_2213</td>
                          <td>Customer</td>
                          <td>Warehouse</td>
                          <td>
                              <span class="badges bg-lightgreen text-center">Completed</span>
                          </td>
                          <td>1002</td>
                          <td>1002</td>
                          <td>1002</td>
                          <td>
                              <span class="badges bg-lightgreen text-center">Completed</span>
                          </td>
                      </tr>
                      <tr>
                          <td>SL_2213</td>
                          <td>Customer</td>
                          <td>Warehouse</td>
                          <td>
                              <span class="badges bg-lightgreen text-center">Completed</span>
                          </td>
                          <td>1002</td>
                          <td>1002</td>
                          <td>1002</td>
                          <td>
                              <span class="badges bg-lightgreen text-center">Completed</span>
                          </td>
                      </tr>
                      <tr>
                          <td>SL_2213</td>
                          <td>Customer</td>
                          <td>Warehouse</td>
                          <td>
                              <span class="badges bg-lightgreen text-center">Completed</span>
                          </td>
                          <td>1002</td>
                          <td>1002</td>
                          <td>1002</td>
                          <td>
                              <span class="badges bg-lightgreen text-center">Completed</span>
                          </td>
                      </tr>
                      <tr>
                          <td>SL_2213</td>
                          <td>Customer</td>
                          <td>Warehouse</td>
                          <td>
                              <span class="badges bg-lightgreen text-center">Completed</span>
                          </td>
                          <td>1002</td>
                          <td>1002</td>
                          <td>1002</td>
                          <td>
                              <span class="badges bg-lightgreen text-center">Completed</span>
                          </td>
                      </tr>
                      <tr>
                          <td>SL_2213</td>
                          <td>Customer</td>
                          <td>Warehouse</td>
                          <td>
                              <span class="badges bg-lightgreen text-center">Completed</span>
                          </td>
                          <td>1002</td>
                          <td>1002</td>
                          <td>1002</td>
                          <td>
                              <span class="badges bg-lightgreen text-center">Completed</span>
                          </td>
                      </tr>
                      <tr>
                          <td>SL_2213</td>
                          <td>Customer</td>
                          <td>Warehouse</td>
                          <td>
                              <span class="badges bg-lightgreen text-center">Completed</span>
                          </td>
                          <td>1002</td>
                          <td>1002</td>
                          <td>1002</td>
                          <td>
                              <span class="badges bg-lightgreen text-center">Completed</span>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
      <div class="card-footer border-0 bg-white p-0 m-0">
          <div class="row align-items-center text-end justify-content-end">
              <div class="col-auto">
                  <p class="subheading col-form-label">1-4 of 15 entries</p>
              </div>
              <div class="col-auto">
                  <div class="new-pagination">
                      <a href="#" class="rounded-start">❮</a>
                      <a href="#" class="rounded-end">❯</a>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
</div>
<!-- Recent Sales End -->

<!-- Calendar Modal -->
<div class="modal fade" id="myModal" aria-labelledby="exampleModalToggleLabel" tabindex="-1"
style="display: none" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content calendar-modal">
      <div class="modal-header border-0 text-white">
          <button type="button" class="btn-close text-white calendar-close-btn"
              data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div id="datepicker"></div>
      </div>
  </div>
</div>
</div>


<script>
    // Function to update the greeting based on current time
    function updateGreeting() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();

        var greetingElement = document.getElementById('greeting');

        if (hours >= 5 && hours < 12) {
            greetingElement.textContent = "Good Morning,!";
        } else if (hours >= 12 && hours < 14) {
            greetingElement.textContent = "Good Afternoon,!";
        } else if (hours >= 14 && hours < 18) {
            greetingElement.textContent = "Good Evening, !";
        } else {
            greetingElement.textContent = "Good Night, !";
        }
    }
    // Call the function initially when the page loads
    updateGreeting();
</script>
@endsection
