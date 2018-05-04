<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;

use \Kodeine\Acl\Models\Eloquent\Role as Role;
use \Kodeine\Acl\Models\Eloquent\Permission as Permission;
use \App\User as User;

class CreateInitialProductionDataSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		// RUN ONLY IN PRODUCTION!
		if (App::environment('production')) {
			
			// Create default users
			\App\User::unguard();
			
			\App\User::create([
				'id'				=> 1,
                'name'              => 'Administrator',
                'email'             => 'admin@rentling.group',
                'password'          => bcrypt('adm123'),
                'confirmed'         => 1,
                'admin'             => 1,
                'confirmation_code' => md5(microtime() . env('APP_KEY')),
            ]);
			
			// Create default roles
			$role      = new Role();
            $roleAdmin = $role->create([
                'name'        => 'Administrator',
                'slug'        => 'administrator',
                'description' => 'administrator privileges'
            ]);
			User::find(1)->assignRole($roleAdmin);
			
			$role         = new Role();
            $roleLandlord = $role->create([
                'name'        => 'Landlord',
                'slug'        => 'landlord',
                'description' => 'landlord privileges'
            ]);
			
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

			$role        = new Role();
            $roleManager = $role->create([
                'name'        => 'Manager',
                'slug'        => 'manager',
                'description' => 'Manager privileges'
            ]);
			
			$role      = new Role();
            $roleGuest = $role->create([
                'name'        => 'Guest',
                'slug'        => 'guest',
                'description' => 'Guest privileges'
            ]);
			
			$role        = new Role();
			$role->create([
				'name'        => 'DepositRelay',
				'slug'        => 'depoistrelay',
				'description' => 'Deposit Relay'
			]);


			// Clients
			\App\Models\Client::create([
				'name'   => '1stHome',
				'domain' => '1stHome.Rentling.group'
			]);
			
			// Countries
			\App\Models\Country::create([
				'title' => 'Netherlands',
			]);
			\App\Models\Country::create([
				'title' => 'Germany',
			]);
			\App\Models\Country::create([
				'title' => 'United Kingdom',
			]);
			\App\Models\Country::create([
				'title' => 'France',
			]);
			
			// Languages
			$language            = new \App\Models\Language();
            $language->name      = 'English';
            $language->lang_code = 'en';
            $language->icon      = "gb.png";
            $language->save();

            $language            = new \App\Models\Language();
            $language->name      = 'Nederlands';
            $language->lang_code = 'nl';
            $language->icon      = "nl.png";
            $language->save();
			
			$language            = new \App\Models\Language();
            $language->name      = 'French';
            $language->lang_code = 'fr';
            $language->icon      = "fr.png";

			// Property types
			\App\Models\PropertyType::create([
				'title' => 'Room',
			]);
			\App\Models\PropertyType::create([
				'title' => 'Apartment',
			]);
			\App\Models\PropertyType::create([
				'title' => 'House',
			]);
			
			// Transaction recurrence
			\App\Models\TransactionRecurring::create([
				'title' => 'Weekly',
			]);
			\App\Models\TransactionRecurring::create([
				'title' => 'Bi-Weekly',
			]);
			\App\Models\TransactionRecurring::create([
				'title' => 'Monthly',
			]);
			\App\Models\TransactionRecurring::create([
				'title' => 'Semi-Monthly',
			]);
			\App\Models\TransactionRecurring::create([
				'title' => 'Annually',
			]);
			\App\Models\TransactionRecurring::create([
				'title' => 'Semi-Annually',
			]);
			\App\Models\TransactionRecurring::create([
				'title' => 'Quarterly',
			]);
			
			// Transaction categories
			\App\Models\TransactionCategory::create([
				'title' => 'Rent',
				'transaction_recurring_id' => 3
			]);
			\App\Models\TransactionCategory::create([
				'title' => 'Deposit',
			]);
			\App\Models\TransactionCategory::create([
				'title' => 'Commission',
			]);
			\App\Models\TransactionCategory::create([
				'title' => 'Internet',
				'transaction_recurring_id' => 3
			]);
			\App\Models\TransactionCategory::create([
				'title' => 'Utilities',
				'transaction_recurring_id' => 3
			]);
			\App\Models\TransactionCategory::create([
				'title' => 'Cleaning',
			]);
			
			// Amenity categories
			\App\Models\AmenityCategory::create([
				'title' => 'Building',
			]);
			\App\Models\AmenityCategory::create([
				'title' => 'Facilities',
			]);
			\App\Models\AmenityCategory::create([
				'title' => 'Accesibility',
			]);
			\App\Models\AmenityCategory::create([
				'title' => 'Property',
			]);
			\App\Models\AmenityCategory::create([
				'title' => 'Furnishing',
			]);
			\App\Models\AmenityCategory::create([
				'title' => 'Utilities Included',
			]);
			\App\Models\AmenityCategory::create([
				'title' => 'Extras',
			]);
			
			// Amenities
			\App\Models\Amenity::create([
				'title' => 'Construction year',
				'amenity_category_id' => 1,
				'type' => 'INT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Floors',
				'amenity_category_id' => 1,
				'type' => 'INT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Energy label',
				'amenity_category_id' => 1,
				'type' => 'INT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Video surveillance',
				'amenity_category_id' => 1,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Gym',
				'amenity_category_id' => 2,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Parking',
				'amenity_category_id' => 2,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Garage',
				'amenity_category_id' => 2,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Garden',
				'amenity_category_id' => 2,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Disability ramps',
				'amenity_category_id' => 3,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Elevator',
				'amenity_category_id' => 3,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Bathroom',
				'amenity_category_id' => 4,
				'type' => 'INT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Toilet',
				'amenity_category_id' => 4,
				'type' => 'INT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Balcony',
				'amenity_category_id' => 4,
				'type' => 'INT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Terrace',
				'amenity_category_id' => 4,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Basement',
				'amenity_category_id' => 4,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Dishwasher',
				'amenity_category_id' => 4,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Washing machine',
				'amenity_category_id' => 4,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Dryer',
				'amenity_category_id' => 4,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Fridge',
				'amenity_category_id' => 4,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Wifi',
				'amenity_category_id' => 4,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Furnished',
				'amenity_category_id' => 5,
				'type' => 'VARCHAR'
			]);
			\App\Models\Amenity::create([
				'title' => 'Double-glaze windows',
				'amenity_category_id' => 5,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Bed',
				'amenity_category_id' => 5,
				'type' => 'INT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Desk',
				'amenity_category_id' => 5,
				'type' => 'INT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Closet',
				'amenity_category_id' => 5,
				'type' => 'INT'
			]);
			\App\Models\Amenity::create([
				'title' => 'TV',
				'amenity_category_id' => 5,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Gas',
				'amenity_category_id' => 6,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Water',
				'amenity_category_id' => 6,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Electricity',
				'amenity_category_id' => 6,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Internet',
				'amenity_category_id' => 6,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Registration',
				'amenity_category_id' => 7,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Smoking',
				'amenity_category_id' => 7,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Pets',
				'amenity_category_id' => 7,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Events',
				'amenity_category_id' => 7,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Meeting room',
				'amenity_category_id' => 2,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Kitchen',
				'amenity_category_id' => 2,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Phone',
				'amenity_category_id' => 2,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Lunch facilities',
				'amenity_category_id' => 2,
				'type' => 'TINYINT'
			]);
			\App\Models\Amenity::create([
				'title' => 'Reception',
				'amenity_category_id' => 2,
				'type' => 'TINYINT'
			]);

			// Currencies
			\App\Models\Currency::create([
				'title' => 'eur',
				'symbol' => '€',
				'html'=>'&euro;',
				'weight' => 1
			]);
			\App\Models\Currency::create([
				'title' => 'gbp',
				'symbol'=>'£',
				'html'=>'&pound;',
				'weight' => 2
			]);
			\App\Models\Currency::create([
				'title' => 'usd',
				'symbol'=>'$',
				'html'=>'$',
				'weight' => 3
			]);
			
			// Menu
			\App\Models\Menu::create([
                'label'  => 'Dashboard',
                'url'    => '#/dashboard',
                'icon'   => 'icon-speedometer',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Properties',
                'url'    => '#/properties',
                'icon'   => 'icon-home',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Tenants',
                'url'    => '#/tenants',
                'icon'   => 'icon-user',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Documents',
                'url'    => '#/documents',
                'icon'   => 'icon-doc',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Finances',
                'url'    => '#/finances',
                'icon'   => 'icon-credit-card',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Messages',
                'url'    => '#/messages',
                'icon'   => 'icon-envelope',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Planning',
                'url'    => '#/planning',
                'icon'   => 'icon-calendar',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Settings',
                'url'    => '#/settings',
                'icon'   => 'icon-settings',
                'roles'  => json_encode(['administrator', 'tenant', 'landlord', 'manager']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Translations',
                'url'    => '#/translations',
                'icon'   => 'icon-book-open',
                'roles'  => json_encode(['administrator']),
                'status' => 1
            ]);

            \App\Models\Menu::create([
                'label'  => 'Emails',
                'url'    => '#/emails',
                'icon'   => 'icon-envelope-open',
                'roles'  => json_encode(['administrator']),
                'status' => 1
            ]);
			
			// Property type amenities
			//Room
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 1,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 2,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 3,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 4,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 5,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 6,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 7,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 8,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 9,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 10,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 11,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 12,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 13,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 14,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 15,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 16,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 17,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 18,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 19,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 20,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 21,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 22,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 23,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 24,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 25,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 26,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 27,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 28,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 29,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 29,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 30,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 31,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 32,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 33,
				'property_type_id'=>1
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 34,
				'property_type_id'=>1
			]);
		  //Apartment
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 1,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 2,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 3,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 4,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 5,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 6,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 7,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 8,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 9,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 10,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 11,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 12,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 13,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 14,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 15,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 16,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 17,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 18,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 19,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 20,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 21,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 22,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 27,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 28,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 29,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 30,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 31,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 32,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 33,
				'property_type_id'=>2
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 34,
				'property_type_id'=>2
			]);
			//House
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 1,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 2,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 3,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 4,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 5,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 6,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 7,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 8,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 9,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 10,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 11,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 12,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 13,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 14,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 15,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 16,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 17,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 18,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 19,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 20,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 21,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 22,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 27,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 28,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 29,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 30,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 31,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 32,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 33,
				'property_type_id'=>3
			]);
			\App\Models\PropertyTypeAmenity::create([
				'amenity_id' => 34,
				'property_type_id'=>3
			]);
			
			// Migrate 1stHome data
			$filename = 'database/migrations/scripts/1stHome_Rentling_Data_Migrate.sql';
			if (File::exists($filename))
				DB::unprepared(File::get($filename));
			else
			{
				$output = new ConsoleOutput();
				$output->writeln('File ' . $filename . ' was not found.');
			}
		}
		else {
			$output = new ConsoleOutput();
			$output->writeln('Not running in production, skipping initial dataset creation.');
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
