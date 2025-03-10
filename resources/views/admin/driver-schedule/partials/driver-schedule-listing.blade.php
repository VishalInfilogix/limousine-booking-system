@php
    use App\CustomHelper;
    $user = Auth::user();
    $userTypeSlug = $user->userType->slug ?? null;
@endphp
@forelse($driversBooking as $key => $drivers)
    @php
        $pickUpLocation = null;
        $pickupLocationId = $drivers->pick_up_location_id ?? null;
        if ($pickupLocationId && $pickupLocationId !== 8) {
            $pickUpLocation = $drivers->pickUpLocation->name ?? null;
        } else {
            $pickUpLocation = $drivers->pick_up_location;
        }

        $dropOffLocation = null;
        if ($drivers->service_type_id === 3) {
            if (!empty($drivers->flight_detail)) {
                $dropOffLocation = $drivers->departure_time
                    ? $drivers->flight_detail .
                        ' / ' .
                        CustomHelper::parseDateTime($drivers->departure_time, 'd M, Y H:i')
                    : $drivers->flight_detail;
                $dropOffLocationEditVal = $drivers->flight_detail ?? null;
            }
        } else {
            $dropOffLocationId = $drivers->drop_off_location_id ?? null;
            if ($dropOffLocationId && $dropOffLocationId !== 8) {
                $dropOffLocation = $drivers->dropOffLocation->name ?? null;
            } else {
                $dropOffLocation = $drivers->drop_of_location;
            }
        }
        $pickUpTime = 'N/A';
        $pickup = $drivers->pickup_time ? CustomHelper::formatTime($drivers->pickup_time) : null;
        if ($drivers->service_type_id === 4) {
            if ($pickup && $drivers->no_of_hours) {
                $pickupDateTime = new DateTime($pickup);
                $pickupDateTime->modify('+' . $drivers->no_of_hours . ' hours');
                $endTime = $pickupDateTime->format('H:i');
                $pickUpTime = $pickup . '</br>(' . $endTime . ')';
            } else {
                $pickUpTime = 'N/A';
            }
        } else {
            $pickUpTime = $pickup ? $pickup : 'N/A';
        }
        $firstName = $drivers->updatedBy->first_name ?? null;
        $lastName = $drivers->updatedBy->last_name ?? null;
        $fullName = CustomHelper::getFullName($firstName, $lastName);
        $hotel = $drivers->client->hotel->name ?? null;
        if ($hotel) {
            $hotelValue = $hotel;
        } else {
            $hotelValue = 'N/A';
        }

        $attachment = $drivers->attachment ?? null;
        $guestNames = $drivers->guest_name ?? null;
        $resultGuestName = null;
        if ($guestNames) {
            $guestNameArray = explode(',', $guestNames);
            foreach ($guestNameArray as $key => $name) {
                $resultGuestName .= $key + 1 . '. ' . ucfirst(trim($name)) . '<br>';
            }
        }
        $VehicleClassName = $drivers->vehicle->vehicleClass->name ?? null;
        $VehicleNumber = $drivers->vehicle->vehicle_number ?? null;
        $Vehicle = null;
        if ($VehicleClassName && $VehicleNumber) {
            $Vehicle = $VehicleClassName . '<br>' . $VehicleNumber;
        }
        $rowClass = '';
        if ($drivers->status === 'PENDING') {
            $rowClass = 'pending-status';
        } elseif ($drivers->status === 'COMPLETED') {
            $rowClass = 'completed-status';
        } elseif ($drivers->status === 'CANCELLED') {
            $rowClass = 'cancelled-status';
        }

    @endphp
    <tr class="{{ $rowClass }}" data-id="{{ $drivers->id }}">
        <td>
            @if ($attachment)
                <a target="blank" href="{{ Storage::url($attachment) }}" class="attachment-link">
                    <i class="fa fa-paperclip text-dark"></i>
                </a>
            @endif
            #{{ $drivers->id }}
        </td>
        <td>{!! $pickUpTime ?? 'N/A' !!}</td>
        <td class="text-truncate">{{ $drivers->serviceType->name ?? 'N/A' }}</td>
        <td class="text-truncate">{{ $pickUpLocation ?? 'N/A' }}</td>
        <td class="text-truncate">{{ $dropOffLocation ?? 'N/A' }}</td>
        <td class="text-truncate">{!! $resultGuestName ?? 'N/A' !!}</td>
        @if ($userTypeSlug === null || in_array($userTypeSlug, ['admin', 'admin-staff']))
            <td class="text-truncate">{!! $hotelValue !!}</td>
        @endif
        <td class="text-truncate toggalContact">
            {{ $drivers->country_code ? '+(' . $drivers->country_code . ')' : '' }}{{ $drivers->phone ?? 'N/A' }}</td>
        <td class="text-truncate" style="max-width: 200px" title="{{ $drivers->driver_remark ?? 'N/A' }}">
            {{ $drivers->driver_remark ?? 'N/A' }}</td>
        <td class="text-truncate">{{ $drivers->driver->name ?? 'N/A' }}</td>
        <td class="text-truncate">{!! $Vehicle ?? 'N/A' !!}</td>
    </tr>
@empty
    <tr>
        @if ($userTypeSlug === null || in_array($userTypeSlug, ['admin', 'admin-staff']))
            <td colspan="18" class="text-center">No Record Found.</td>
        @else
            <td colspan="11" class="text-center">No Record Found.</td>
        @endif
    </tr>
@endforelse
