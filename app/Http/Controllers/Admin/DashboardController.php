<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Invoice;
use App\Models\Landlord;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\PropertyFinancial;
use App\Models\PropertyTenant;
use App\Models\PropertyTransaction;
use App\Models\Tenant;
use Kodeine\Acl\Models\Eloquent\Role as Role;
use Kodeine\Acl\Models\Eloquent\Permission as Permission;
use App\Models\TenantInvitation;
use App\Models\LandlordInvitation;
use Auth;

use App\User;
use App\Models\Property;
use App\DepositRelay;

class DashboardController extends AdminController {

	public function __construct () {
		parent::__construct();
	}

	public function index () {
		$title = "Rentling Dashboard";

		return view('admin.dashboard.index', compact('title'));
	}
	public function newUserWizardVideo(){
        $user = Auth::user();
        $roles = $this->getRoleMethod($user);
        return view('admin.new-user.video');
    }

	public function newUserWizard(){
	    $user = Auth::user();
        $roles = $this->getRoleMethod($user);
        $landlord = '';
        $tenant = '';
        $existUser = 0;
        $selectedType = '';
        $invitationID = 0;
        $invitationCheck = 0;
        $propertyTenant = '';
        $property = '';
        $rent_type = '';
        if (in_array('tenant', $roles)) {
//            $tenantInvitation = TenantInvitation::where('tenant_email', $user->email)->first();
//            $landlord = $tenantInvitation->landlord;
//            $existUser = 1;
//            $selectedType = 'tenant';
//            $invitationID = $tenantInvitation->id;
        }
        if (in_array('landlord', $roles)) {
            $landlordInvitation = LandlordInvitation::where('landlord_email', $user->email)->first();
            if(count($landlordInvitation) >0){
                $tenant = User::where('id', $landlordInvitation->tenant_id)->first();
                $propertyTenant = PropertyTenant::where('user_id', $tenant->id)->first();
                if(count($propertyTenant) >0){
                    $property = Property::where('id', $propertyTenant->property_id)->first();
                }
                $invitationCheck = 1;
                $invitationID = $landlordInvitation->id;
            }else{
                $invitationCheck =0;
            }
            $existUser = 1;
            $selectedType = 'landlord';
        }
	    return view('admin.new-user.index',compact('landlord', 'tenant' ,'existUser', 'selectedType','invitationID', 'invitationCheck', 'property', 'propertyTenant'));
    }

	public function getDashboardStats () {

        $roles = $this->getRoleMethod(Auth::getUser());
//        $roles  = Auth::getUser()->getRoles()->toArray();

		$return = [];

		if (in_array('tenant', $roles)) {
			$return = $this->getDashboardStatsTenant();
		}

		if (in_array('landlord', $roles)) {
			$return = $this->getDashboardStatsLandlord();
		}

		if (!empty($return)) {
			return response()->json($return);
		}

		return response()->json(['status' => 0]);
	}

	public function getDepositRelay() {
        $roles = $this->getRoleMethod(Auth::getUser());

        $countDepositRelay = 0;
        $user = Auth::user();
        if (in_array('depositrelay', $roles)  && in_array('landlord', $roles)) {
           $countDepositRelay = DepositRelay::where('landlord_email',$user->email)->count();

        }
        if (in_array('depositrelay', $roles)  && in_array('tenant', $roles)) {
            $countDepositRelay = DepositRelay::where('tenant_email',$user->email)->count();
        }
        $data = [
          'count' =>$countDepositRelay
        ];

        return response()->json($data);

    }
	public function getDashboardStatsTenant () {
		$user = Auth::user();

		$fd = new \DateTime('first day of this month');
		$ld = new \DateTime('last day of this month');

		$property = PropertyTenant::where('user_id', $user->id)->first();
		if ($property) {
			$landlord        = $property->property->landlord;
			$landlordProfile = $landlord->profile;
			$invoice         = Invoice::where('tenant_id', $user->id)
				->whereBetween('due_at', [$fd->format('Y-m-d H:i:s'), $ld->format('Y-m-d H:i:s')])
				->first();

			$payment = Payment::where('invoice_id', $invoice->id)->first();
			if (empty($payment)) {
				$rentDueDate = date('d F', strtotime($invoice->due_at));
			} else {
				$rentDueDate = $property->collection_day . ' ' . date('F', strtotime("+1 month", time()));
			}

			return [
				'role'             => 'tenant',
				'rent_amount'      => $property->rent,
				'address'          => $property->property->address,
				'landlord_contact' => [
					'name'  => $landlord->name,
					'phone' => (!empty($landlordProfile->phone) ? $landlordProfile->phone : ''),
					'email' => $landlord->email,
				],
				'rent_due_date'    => $rentDueDate
			];
		} else {
			return [
				'role'             => 'tenant',
				'rent_amount'      => 0,
				'address'          => '-',
				'landlord_contact' => [
					'name'  => trans('tenant.not_assigned'),
					'phone' => '-',
					'email' => '',
				],
				'rent_due_date'    => '-'
			];
		}
	}

	public function getDashboardStatsLandlord () {
		$userId = Auth::user()->id;
		// -- top widget stats
		$allProperties            = Property::where('user_id', $userId)->where('status', 1)->get(['id']);
		$allRentedPropertiesCount = Property::where('user_id', $userId)->where('status', 2)->count();
		$allTenants               = User::where('parent_id', $userId)->count();
		// -- end top widget stats

		$rentAcrossProperties = 0;
		foreach ($allProperties as $property) {
			$financials = PropertyTransaction::where('property_id', $property->id)->get(['amount_total'])->pluck('amount_total');


			if ($financials) {
				$rentAcrossProperties += array_sum($financials->toArray());
			}
		}


		// -- chart stats
		// -- end chart stats

		return [
			'role'             => 'landlord',
			'properties'       => ((count($allProperties) > 0) ? count($allProperties) : 0),
			'rentedProperties' => (($allRentedPropertiesCount > 0) ? $allRentedPropertiesCount : 0),
			'tenants'          => (($allTenants > 0) ? $allTenants : 0),
			'totalRent'        => (isset($rentAcrossProperties) ? $rentAcrossProperties : '0')
		];
	}

	public function getDashboardTotal () {
		$total  = 0;
		$userId = Auth::getUser()->id;

		$propertyFinancials = PropertyTransaction::join('properties', function ($join) use ($userId) {
			$join->on('properties.id', '=', 'property_transactions.property_id')
				->where('properties.user_id', '=', $userId);
		})->where('transaction_category_id', 1)->orWhere('transaction_category_id', 2)
			->get();
		if (!empty($propertyFinancials)) {
			foreach ($propertyFinancials as $cItem) {
				$total += $cItem['amount_total'];
			}
		}

		return response()->json(
			['total' => $total]
		);
	}

	public function getDashboardRent () {
		$user               = Auth::user();
		$return             = [];
		$return['total']    = 0;
		$return['received'] = 0;
		$rows               = [];

		$userId = Auth::getUser()->id;

		$fd              = new \DateTime('first day of this month');
		$ld              = new \DateTime('last day of this month');
		$invoices        = Invoice::where('landlord_id', $userId)
			->whereBetween('due_at', [$fd->format('Y-m-d H:i:s'), $ld->format('Y-m-d H:i:s')])
			->get()
			->toArray();
		$return['total'] = array_sum(array_column($invoices, 'amount'));

		$payments            = Payment::whereIn('invoice_id', array_column($invoices, 'id'))
			->get()
			->toArray();
		$return['received']  = array_sum(array_column($payments, 'amount'));
		$return['remaining'] = $return['total'] - $return['received'];
		$tenantPayment       = [];

		foreach ($payments as $payment) {
			$tenantPayment[ $payment['tenant_id'] ]['payment'][] = $payment;
			$tenantPayment[ $payment['tenant_id'] ]['invoice']   = $invoices[ array_search($payment['invoice_id'], array_column($invoices, 'id')) ];
		}

		foreach ($tenantPayment as $tPayment) {
			$row                      = [];
			$row['payment']['amount'] = array_sum(array_column($tPayment['payment'], 'amount'));

			usort($tPayment['payment'], function ($a, $b) {
				$ad = new \DateTime($a['created_at']);
				$bd = new \DateTime($b['created_at']);

				if ($ad == $bd) {
					return 0;
				}

				return $ad < $bd ? -1 : 1;
			});

			if ($row['payment']['amount'] == $tPayment['invoice']['amount']) {
				$row['payment']['status'] = 'Full ';
			} else {
				$row['payment']['status'] = 'Partial ';
			}

			$lastPayment = end($tPayment['payment']);
			if (new \DateTime($lastPayment['created_at']) > new \DateTime($tPayment['invoice']['due_at'])) {
				$row['payment']['status'] .= 'Late';
			} else {
				$row['payment']['status'] .= 'On time';
			}

			$row['payment']['status'] = trans($row['payment']['status']);

			$tenant                  = Tenant::where('id', $tPayment['invoice']['tenant_id'])->first();
			$profile                 = Profile::where('user_id', $tPayment['invoice']['tenant_id'])->first();
			$row['tenant']['name']   = $tenant['name'];
			$row['tenant']['avatar'] = 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar9.png';
			if (!empty($profile)) {
				$row['tenant']['avatar'] = $profile['avatar'];
			}

			$row['property']['id'] = $tPayment['invoice']['property_id'];

			$return['rows'][] = $row;
		}

		if (!empty($return) && !empty($return['rows'])) {
			return response()->json($return);
		} else {

			if ($user->has_demo) {
				//fill in demo data
				$faker = \Faker\Factory::create();

				foreach (range(1, 3) as $index) {
					$row['tenant'] = [
						'name'   => $faker->unique()->userName,
						'avatar' => 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars' . rand(1, 9) . '.png',

					];

					$row['payment'] = [
						'amount' => number_format(rand(150, 2500)),
						'status' => 'On Time, Full'
					];

					$return['rows'][] = $row;
				}
				$return['demo'] = 1;

				return response()->json($return);
			}
		}
	}

	public function getDashboardLatest () {

		$user   = Auth::user();
        $roles = $this->getRoleMethod(Auth::getUser());
//		$roles  = Auth::getUser()->getRoles()->toArray();
		$return = [];

		// payments
		if (in_array('landlord', $roles)) { // user is landlord. he received money
			$payments = Payment::where('landlord_id', Auth::getUser()->id)->get();
			foreach ($payments as $payment) {
				$cPayment = [];

				$cPayment['date'] = $payment->created_at->diffForHumans();
				$cPayment['name'] = $payment->tenant->name;

				$return['payments'][] = $cPayment;
			}
		}

		// messages
		$messages = Auth::user()->orderedMessages->groupBy('thread');
		foreach ($messages as $message) {
			// use the last message of the thread
			$lastMessage                  = $message->first();
			$cMessage                     = [];
			$cMessage['sender']['name']   = $lastMessage->sender->name;
			$cMessage['sender']['avatar'] = !empty($lastMessage->sender->profile->avatar) ? $lastMessage->sender->profile->avatar : 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar9.png';
			$cMessage['text']             = $lastMessage->text;
			$cMessage['read']             = $lastMessage->pivot->read_date == TRUE;
			$cMessage['thread_id']        = $lastMessage->thread;
			$cMessage['date']             = $lastMessage->created_at->diffForHumans();
			$return['messages'][]         = $cMessage;
		}

		/**
		 * Check if we need to display demo data
		 */

		if (empty($return['payments'])) {
			if ($user->has_demo) {
				//fill in demo data
				$faker = \Faker\Factory::create();

				$return['demo'] = 1;
				foreach (range(1, 5) as $index) {
					$return['payments'][] = [
						'date' => rand(1, 23) . ' hours ago',
						'name' => $faker->name()
					];
				}
			}
		}

		if (!empty($return)) {
			return response()->json($return);
		}

		return response()->json(['status' => 0]);
	}

    public function getRoleMethod($user){
	    return is_null($user->role())? [] : $user->role()->pluck('slug')->toArray();
    }

    public function getDashboardMonthOverview () {
		$user  = Auth::getUser();
		$roles = $this->getRoleMethod($user);
//		$roles = $user->getRoles()->toArray();

		if (in_array('landlord', $roles)) {

			$return          = [];
			$return['total'] = 0;
			$properties      = Landlord::where('id', $user->id)->first()->properties;

			$fd              = new \DateTime('first day of this month');
			$ld              = new \DateTime('last day of this month');

			foreach ($properties as $property) {
				$propertyTenants = PropertyTenant::where('property_id', $property['id'])
					->where('start_date', '<', $fd->format('Y-m-d'))
					->where('end_date', '>', $ld)
					->get();

				foreach ($propertyTenants as $propertyTenant) {
					$return['total'] += $propertyTenant['rent'];
				}
			}

			$return['expenses'] = 0; // hardcoding for now until expenses is implemented
			$return['profit']   = $return['total'] - $return['expenses'];

			return response()->json($return);
		}
		return response()->json(['status' => 0]);
	}


	public function getDashboardTenantStatus () {
		$user  = Auth::getUser();
        $roles = $this->getRoleMethod($user);
//		$roles = $user->getRoles()->toArray();

		if (in_array('landlord', $roles)) {
			$return              = [];
			$return['total']     = 0;
			$return['movingout'] = 0;
			$return['movingin']  = 0;

			$fd   = date('Y-m-d H:i:s', strtotime('first day of this month'));
			$ld   = date('Y-m-d H:i:s', strtotime('last day of this month'));
			$fdnm = date('Y-m-d H:i:s', strtotime('first day of next month'));
			$ldnm = date('Y-m-d H:i:s', strtotime('last day of next month'));

			$properties = Landlord::where('id', $user->id)->first()->properties;

			foreach ($properties as $property) {
				foreach ($property->tenants as $propertyTenant) {
					if ($propertyTenant['start_date'] <= $fd && $propertyTenant['end_date'] >= $ld) {
						$return['total'] += 1;
					}
					if ($propertyTenant['start_date'] >= $fdnm && $propertyTenant['start_date'] <= $ldnm) {
						$return['movingin'] += 1;
					}

					if ($propertyTenant['end_date'] >= $fdnm && $propertyTenant['end_date'] <= $ldnm) {
						$return['movingout'] += 1;
					}
				}
			}

			return response()->json($return);
		}

		return response()->json(['status' => 0]);
	}

}
