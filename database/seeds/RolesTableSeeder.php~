<?php

    use Illuminate\Database\Seeder;
    use \Kodeine\Acl\Models\Eloquent\Role as Role;
    use \Kodeine\Acl\Models\Eloquent\Permission as Permission;
    use \App\User as User;

    class RolesTableSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run () {
            $role      = new Role();
            $roleAdmin = $role->create([
                'name'        => 'Administrator',
                'slug'        => 'administrator',
                'description' => 'administrator privileges'
            ]);

            ### assign admin roles
            User::find(1)->assignRole($roleAdmin);
            User::find(4)->assignRole($roleAdmin);
            User::find(7)->assignRole($roleAdmin);
            User::find(10)->assignRole($roleAdmin);
            User::find(13)->assignRole($roleAdmin);
            User::find(16)->assignRole($roleAdmin);

            $role         = new Role();
            $roleLandlord = $role->create([
                'name'        => 'Landlord',
                'slug'        => 'landlord',
                'description' => 'landlord privileges'
            ]);

            User::find(2)->assignRole($roleLandlord);
            User::find(5)->assignRole($roleLandlord);
            User::find(8)->assignRole($roleLandlord);
            User::find(11)->assignRole($roleLandlord);
            User::find(14)->assignRole($roleLandlord);
            User::find(17)->assignRole($roleLandlord);

            $permission = new Permission();
            $permUser   = $permission->create([
                'name'        => 'menu',
                'slug'        => [          // pass an array of permissions.
                                            'create'     => TRUE,
                                            'view'       => TRUE,
                                            'update'     => TRUE,
                                            'delete'     => TRUE,
                                            'view.phone' => TRUE
                ],
                'description' => 'manage user permissions'
            ]);

            $roleLandlord->assignPermission($permUser);

            $role           = new Role();
            $roleAccountant = $role->create([
                'name'        => 'Accountant',
                'slug'        => 'accountant',
                'description' => 'Accountant privileges'
            ]);

            $role       = new Role();
            $roleTenant = $role->create([
                'name'        => 'Tenant',
                'slug'        => 'tenant',
                'description' => 'Tenant privileges'
            ]);

            User::find(3)->assignRole($roleTenant);
            User::find(6)->assignRole($roleTenant);
            User::find(9)->assignRole($roleTenant);
            User::find(12)->assignRole($roleTenant);
            User::find(15)->assignRole($roleTenant);
            User::find(18)->assignRole($roleTenant);

            $role        = new Role();
            $roleManager = $role->create([
                'name'        => 'Manager',
                'slug'        => 'manager',
                'description' => 'Manager privileges'
            ]);

            User::find(13)->assignRole($roleManager);

            $role      = new Role();
            $roleGuest = $role->create([
                'name'        => 'Guest',
                'slug'        => 'guest',
                'description' => 'Guest privileges'
            ]);
        }
    }
