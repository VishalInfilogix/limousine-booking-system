@extends('components.layout')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header border-bottom">
    <div class="container-fluid">
      <div class="mb-2 d-flex align-items-center justify-content-between">
        <div class="col-sm-3">
          <h1 class="head-sm medium">Dashboard</h1>
          <p class="text-xs normal">Business Overview & Administrative Dashboard</p>
        </div>
        
        <div class="col-sm-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                </div>
                <input type="text" id="pickupDateBooking" class="form-control" placeholder="Select date"
                    autocomplete="off" autofocus />
            </div>
        </div>
        <div class="col-sm-3">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header text-center">
              <h4 class="">Types Of Bookings %</h4>
            </div>
            <div class="card-body text-center">
              <canvas id="typesOfBookingChart" width="300" height="300"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header text-center">
              <h4 class="">No Of Bookings</h4>
            </div>
            <div class="card-body text-center">
              <canvas id="lineChartForNoOfBookings" width="300" height="300"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header text-center">
              <h4 class="">Total Bookings Vs Cancellations</h4>
            </div>
            <div class="card-body text-center">
              <canvas id="cancellationBookingsChart" width="300" height="300"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header text-center">
              <h4 class="">No Of Cancellation</h4>
            </div>
            <div class="card-body text-center">
              <canvas id="lineChartForNoOfCancellation" width="300" height="300"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@vite(['resources/js/Dashboard.js'])
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('typesOfBookingChart').getContext('2d');

    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Arrival', 'Transfer', 'Departure', 'Disposal', 'Delivery'],
        datasets: [{
          label: 'Total Bookings',
          data: [
            {{ $finalData['totalArrivalBookings'] }},
            {{ $finalData['totalTransferBookings'] }},
            {{ $finalData['totalDepartureBookings'] }},
            {{ $finalData['totalDisposalBookings'] }},
            {{ $finalData['totalDeliveryBookings'] }}
          ],
          backgroundColor: [
            'rgb(235, 192, 60, 92%)',
            'rgb(147, 196, 125)',
            'rgb(233, 123, 123, 1)',
            'rgb(84, 130, 186)',
            'rgba(153, 102, 255, 0.6)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  });

  
  document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('cancellationBookingsChart').getContext('2d');

    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Cancelled', 'Not Cancelled'],
        datasets: [{
          label: 'Total Bookings Vs Cancellations',
          data: [
            {{ $finalData['totalCancelledBookings'] }},
            {{ $finalData['notCandelledBookings'] }},
          ],
          backgroundColor: [
            'rgb(147, 196, 125)',
            'rgba(153, 102, 255, 0.6)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  });

  document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('lineChartForNoOfBookings').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($finalData['datesForBookings']) !!},
            datasets: [{
                label: 'Bookings Per Day',
                data: {!! json_encode($finalData['bookingsPerDay']) !!},
                borderColor: '#8533ff',
                borderWidth: 2,
                fill: false,
                pointBackgroundColor: 'white',
                pointBorderColor: '#8533ff',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Dates'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Bookings'
                    },
                    ticks: {
                      precision: 0
                    }
                }
            }
        }
    });
  });

  document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('lineChartForNoOfCancellation').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($finalData['datesForCancellation']) !!},
            datasets: [{
                label: 'Cancel Per Day',
                data: {!! json_encode($finalData['cancellationPerDay']) !!},
                borderColor: '#8533ff',
                borderWidth: 2,
                fill: false,
                pointBackgroundColor: 'white',
                pointBorderColor: '#8533ff',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Dates'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Bookings'
                    },
                    ticks: {
                      precision: 0
                    }
                }
            }
        }
    });
  });

</script>
@endsection
