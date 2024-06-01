<?php

namespace App\Helpers;

use App\Dto\DataTables\DataTableDefaultFiltersDto;
use Illuminate\Http\Request;

class DataTablesHelper
{
    static public function generateDefaultFilter(Request $request, DataTableDefaultFiltersDto $filters)
    {
        $filters->draw = $request->input('draw');
        $filters->start = $request->input('start');
        $filters->length = $request->input('length');
        $filters->search = $request->input('search')['value'] ?? '';
        $filters->orderColumn = $request->input('order')[0]['column'];
        $filters->orderColumnName = $request->input('columns')[$filters->orderColumn]['data'];
        $filters->orderColumnDir = $request->input('order')[0]['dir'] ?? 'asc';

        $filters->orderMultipleColumns = '';
        $order = $request->input('order');

        if ($order) {
            foreach ($order as $key => $order_column_index) {
                $order_column = $request->input('columns.' . $order_column_index['column']);

                if ($order_column) {
                    if ($filters->orderMultipleColumns) {
                        $filters->orderMultipleColumns .= ", ";
                    }

                    $filters->orderMultipleColumns .= $order_column['data'] . " " . $request->input('order.' . $key . '.dir');
                }
            }
        }

        return $filters;
    }
}