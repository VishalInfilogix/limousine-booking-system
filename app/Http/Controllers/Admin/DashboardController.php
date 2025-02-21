<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BookingService;
use Carbon\Carbon;

/**
 * Class DashboardController
 * 
 * @package  App\Http\Controllers\Admin
 */
class DashboardController extends Controller
{

    public function __construct(
        private BookingService $bookingService,
    ) {
    }

    /**
     * Display the dashboard.
     *
     * @param Request $request The HTTP request instance.
     * @return \Illuminate\Contracts\View\View The view for displaying the dashboard.
     */
    public function index(Request $request)
    {
        $endDate = Carbon::today();

        $startDate = Carbon::today()->subMonths();

        $data = [];
        $data['endDate'] = $endDate;
        $data['startDate'] = $startDate;

        $finalData = [];

        $bookingDataForPieChart = $this->bookingService->getBookingDataForDashboardPieChart($data);


        $totalBookings = count($bookingDataForPieChart);
        
        $totalArrivalBookings = number_format((count($bookingDataForPieChart->where('service_type_id', 1))/$totalBookings) * 100, 2, '.', '');
        $totalTransferBookings = number_format((count($bookingDataForPieChart->where('service_type_id', 2))/$totalBookings) * 100, 2, '.', '');
        $totalDepartureBookings = number_format((count($bookingDataForPieChart->where('service_type_id', 3))/$totalBookings) * 100, 2, '.', '');
        $totalDisposalBookings = number_format((count($bookingDataForPieChart->where('service_type_id', 4))/$totalBookings) * 100, 2, '.', '');
        $totalDeliveryBookings = number_format((count($bookingDataForPieChart->where('service_type_id', 5))/$totalBookings) * 100, 2, '.', '');

        $totalCancelledBookings = count($bookingDataForPieChart->where('status', 'CANCELLED'));
        
        $notCandelledBookings = $totalBookings - $totalCancelledBookings;

        $bookingDataForLineChart = $this->bookingService->getBookingDataForDashboardForLineChart($data);
        
        $bookingDataForLineChartCancellation = $this->bookingService->getBookingDataForDashboardForLineChartCancellation($data);
        
        $datesForBookings = $bookingDataForLineChart->pluck('date')->map(fn($date) => Carbon::parse($date)->format('Y-m-d'));
        $bookingsPerDay = $bookingDataForLineChart->pluck('count');
        
        $datesForCancellation = $bookingDataForLineChartCancellation->pluck('date')->map(fn($date) => Carbon::parse($date)->format('Y-m-d'));
        $cancellationPerDay = $bookingDataForLineChartCancellation->pluck('count');
        
        $finalData['totalArrivalBookings'] = $totalArrivalBookings;
        $finalData['totalTransferBookings'] = $totalTransferBookings;
        $finalData['totalDepartureBookings'] = $totalDepartureBookings;
        $finalData['totalDisposalBookings'] = $totalDisposalBookings;
        $finalData['totalDeliveryBookings'] = $totalDeliveryBookings;
        $finalData['totalBookings'] = $totalBookings;
        $finalData['totalCancelledBookings'] = $totalCancelledBookings;
        $finalData['notCandelledBookings'] = $notCandelledBookings;
        $finalData['datesForBookings'] = $datesForBookings;
        $finalData['bookingsPerDay'] = $bookingsPerDay;
        $finalData['datesForCancellation'] = $datesForCancellation;
        $finalData['cancellationPerDay'] = $cancellationPerDay;

        return view('admin.dashboard', compact('finalData'));
    }

    public function terms(Request $request)
    {
        $termConditions = Auth::user()->client->hotel->term_conditions ?? null;
        $termConditions = $termConditions ? explode("\r\n", $termConditions) : [];
        return view('admin.terms', compact('termConditions'));
    }
}
