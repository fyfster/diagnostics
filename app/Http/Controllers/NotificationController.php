<?php

namespace App\Http\Controllers;

use App\Classes\Datatables\NotificationDatatablesFormat;
use App\Dto\DataTables\DataTableNotificationFiltersDto;
use App\Helpers\DataTablesHelper;
use App\Models\Car;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends MyController
{
    public function getNotifications()
    {
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->whereNull('read_at')
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead()
    {
        Notification::where('user_id', Auth::user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['message' => __('common.notification_read')]);
    }

    public function getNotificationList()
    {
        $this->data['userId'] = Auth::user()->id;

        $this->data['cars'] = (new Car())->getUserCars(Auth::user()->id);

        return view('notification/notification_list', $this->data);
    }

    public function listDataTables(Request $request, $userId = null)
    {
        $dataTablesFilters = DataTablesHelper::generateDefaultFilter($request, new DataTableNotificationFiltersDto);
        /** @var DataTableNotificationFiltersDto $dataTablesFilters*/
        $dataTablesFilters->userId = $userId;
        $carId = $request->input('car_id');
        if ($carId && !Car::find($carId)) {
            return response()->json('');
        }

        $dataTablesFilters->carId = $carId ? $carId : null;

        $notifications = (new Notification())->dataTablesGetNotifications($dataTablesFilters);

        return response()->json(NotificationDatatablesFormat::format($notifications, $dataTablesFilters));
    }
}
