<?php

    /**
     * Returns default string 'active' if route is active.
     *
     * @param        $route
     * @param string $str
     *
     * @return string
     */
    function set_active ($route, $str = 'active') {

        return call_user_func_array('Request::is', (array)$route) ? $str : '';
    }

    /**
     * Try to detect what kind of action this is so we can add it to notifications
     *
     * @param $method
     * @param $class
     */

    function translateAction ($method, $class) {
        $result          = '';
        $arrKnownActions = [
            'new'    => trans('was created'),
            'create' => trans('was created'),
            'edit'   => trans('was updated'),
            'update' => trans('was updated'),
            'delete' => trans('was deleted'),
            'remove' => trans('was deleted')
        ];
        $class           = str_replace(['App\Http\Controllers\Admin\\', 'Controller', '.php'], '', $class);
        foreach ($arrKnownActions as $action => $actionTranslation) {
            if (stristr($method, $action)) {
                $result['message'] = strtolower($class . ' ' . $actionTranslation);
                $result['action']  = $action . '-' . $class;
            }
        }

        return $result;
    }

    function invoiceStatus ($status) {

        switch ($status) {
            case 1:
                $label = '<span class="label label-sm label-info">Pending</span>';
                break;
            case 2:
                $label = '<span class="label label-sm label-info">Draft</span>';
                break;
            case 3:
                $label = '<span class="label label-sm label-info">Scheduled</span>';
                break;
            case 4:
                $label = '<span class="label label-sm label-info">Outstanding Balance</span>';
                break;
            case 5:
                $label = '<span class="label label-sm label-info">Paid</span>';
                break;
            case 6:
                $label = '<span class="label label-sm label-info">Written Off</span>';
                break;
        }

        return $label;
    }

    function invoiceActions ($id) {
        return '
                    <a href="#/invoice/view/' . $id . '/' . time() . '" class="btn default btn-xs green-stripe">View</a>
                    <a href="/invoice/' . $id . '" class="btn default btn-xs green-stripe">Pay</a>
                    <a onclick="return confirm="' . trans('rt.remove-invoice') . '" href="/invoice/delete/' . $id . '" class="btn-delete btn default btn-xs green-stripe">Delete</a>';
    }

    function tenantActions ($id) {
        $buttons = '';
        $buttons .= '<a href="#/tenant/edit/' . $id . '" class="btn btn-xs btn-circle "><i class="fa fa-pencil"></i><span class="hidden-480">' . trans('actions.edit') . '</span></a>';
        $buttons .= '<a href="#" class="btn-delete btn btn-xs btn-circle red item-remove"><i class="fa fa-trash-o"></i><span class="hidden-480">' . trans('actions.delete') . '</span></a>';
        $buttons .= '<a href="#/invoices/tenant/' . $id . '" class="btn btn-xs btn-circle green "><i class="fa fa-university"></i><span class="hidden-480">' . trans('actions.invoices') . '</span></a>';
        $buttons .= '<a href="#/payments/tenant/' . $id . '" class="btn btn-xs btn-circle blue "><i class="fa fa-money"></i><span class="hidden-480">' . trans('actions.payments') . '</span></a>';

        return $buttons;
    }

    function documentActions ($id) {
        $buttons = '';
        $buttons .= '<a href="#/documents/edit/' . $id . '" class="btn-delete btn btn-xs btn-circle "><i class="fa fa-pencil"></i><span class="hidden-480">' . trans('Edit') . '</span></a>';
        $buttons .= '<a href="#" class="btn btn-xs btn-circle red document-remove"><i class="fa fa-trash-o"></i><span class="hidden-480">' . trans('actions.delete') . '</span></a>';

        return $buttons;
    }

    function propertyActions ($id) {
        $buttons = '';
        $buttons .= '<a href="#properties/view/info/' . $id . '" class="btn btn-xs btn-circle hidden-md hidden-sm hidden-xs"><i class="fa fa-pencil"></i><span class="hidden-480">' . trans('actions.edit') . '</span></a>';
        $buttons .= '<a onclick="return confirm(\'' . trans('actions.remove-property') . '\')" href="properties/delete/' . $id . '" class="btn-delete btn btn-xs btn-circle red  hidden-md hidden-sm hidden-xs"><i class="fa fa-pencil"></i><span class="hidden-480">' . trans('actions.delete') . '</span></a>';
        $buttons .= '<a href="#properties/view/overview/' . $id . '" class="btn btn-xs btn-circle green  hidden-md hidden-sm hidden-xs"><i class="fa fa-search"></i><span class="hidden-480">' . trans('actions.view') . '</span></a>';

        $buttons .= '<div class="btn-group hidden-lg">
                    <button class="btn btn-success btn-sm btn-xs" type="button" style="margin-right:0"">' . trans('actions.actions') . '</button>
                    <button data-toggle="dropdown" class="btn btn-xs btn-sm btn-success dropdown-toggle" type="button" aria-expanded="false"><i class="fa fa-angle-down"></i></button>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="#properties/edit/' . $id . '">' . trans('actions.edit') . '</a></li>
                        <li><a onclick="return confirm(\'' . trans('rt.remove-property') . '\')" class="btn-delete" href="properties/delete/' . $id . '">' . trans('actions.delete') . '</span></a></li>
                        <li><a href="#properties/view/' . $id . '">' . trans('actions.view') . '</a></li>
                    </ul>
                </div>';

        return $buttons;
    }

    /**
     * Convert bytes to human readable format
     *
     * @param integer bytes Size in bytes to convert
     *
     * @return string
     */
    function bytesToSize ($bytes, $precision = 2) {
        $kilobyte = 1024;
        $megabyte = $kilobyte * 1024;
        $gigabyte = $megabyte * 1024;
        $terabyte = $gigabyte * 1024;

        if (($bytes >= 0) && ($bytes < $kilobyte)) {
            return $bytes . ' B';
        } elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
            return round($bytes / $kilobyte, $precision) . ' KB';
        } elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
            return round($bytes / $megabyte, $precision) . ' MB';
        } elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
            return round($bytes / $gigabyte, $precision) . ' GB';
        } elseif ($bytes >= $terabyte) {
            return round($bytes / $terabyte, $precision) . ' TB';
        } else {
            return $bytes . ' B';
        }
    }
