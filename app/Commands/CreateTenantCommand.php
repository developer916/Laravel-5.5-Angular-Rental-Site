<?php

    namespace App\Commands;

    use App\Events\TenantWasCreated;
    use App\Events\TenantWasAssigned;

    use App\Commands\Command;
//    use Illuminate\Contracts\Bus\SelfHandling;

    use Auth;
    use App\Models\Tenant;
    use App\Models\PropertyTenant;
    use App\Models\Role;

    class CreateTenantCommand extends Command  {

        public $tenant;

        public function __construct ($tenantData) {
            $this->tenant = $tenantData;
        }

        public function handle () {

            $tenantRole = Role::where('name', 'Tenant')->first();
            $newTenant  = Tenant::create([
                    'name'      => $this->tenant['name'],
                    'parent_id' => Auth::user()->id,
                    'email'     => $this->tenant['email'],
                    'password'  => bcrypt(md5(time())),
                    'confirmed' => 1,
                    'admin'     => 0
                ]
            );

            if (isset($this->tenant['property_id'])) {
                PropertyTenant::create([
                    'property_id'     => $this->tenant['property_id'],
                    'user_id'         => Auth::user()->id,
                    'assigned_at'     => date('Y:m:d H:i:s'),
                    'contract_period' => $this->tenant['contract_period'],
                    'collection_day'  => $this->tenant['collection_day'],
                    'start_date'      => $this->tenant['movingIn'],
                    'move_out_date'   => $this->tenant['movingOut'],
                    'rent'            => $this->tenant['rent']
                ]);

                \Event::fire(new TenantWasAssigned($this->tenant, 'assign-tenant-email'));
            } else {
                \Event::fire(new TenantWasCreated($this->tenant, 'invite-tenant-email'));
            }
        }
    }
