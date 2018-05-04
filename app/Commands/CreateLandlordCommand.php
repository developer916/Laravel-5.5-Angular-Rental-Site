<?php
namespace App\Commands;

use App\Events\LandlordWasCreated;
use App\Events\TenantWasCreated;
use App\User;
//use Illuminate\Contracts\Bus\SelfHandling;
use Auth;


class CreateLandlordCommand extends Command
{
    public $landlord;

    public function __construct($landlordData)
    {
        $this->landlord = $landlordData;
    }

    public function handle()
    {
        $newLandlord = User::create([
                'name' => $this->landlord['name'],
                'parent_id' => Auth::user()->id,
                'email' => $this->landlord['email'],
                'password' => bcrypt(md5(time())),
                'confirmed' => 1,
                'admin' => 0
            ]
        );

        $newLandlord->assignRole('landlord');

        \Event::fire(new LandlordWasCreated($this->landlord, 'invite-landlord-email'));
    }
}