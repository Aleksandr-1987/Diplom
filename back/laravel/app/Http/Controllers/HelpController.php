<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// For Redis
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\message\Message;
use App\Models\user\Image;
use App\Models\forms\Credential;

use App\Models\forms\Baby;
use App\Models\forms\FormAgegroup;
use App\Models\forms\FormDiagnose;
use App\Models\forms\FormDutie;
use App\Models\forms\FormEducation;
use App\Models\forms\FormJoboption;
use App\Models\forms\UserLanguages;
use App\Models\forms\FormTypework;

use App\Models\forms\Keeper;
use App\Models\forms\FormKeeperdutie;
use App\Models\forms\FormKeeperjoboption;
use App\Models\forms\FormKeeperpreference;
use App\Models\forms\FormKeepertypework;

use App\Models\forms\Nurse;
use App\Models\forms\FormNursedutie;
use App\Models\forms\FormNurseeducation;
use App\Models\forms\FormNursejoboption;
use App\Models\forms\FormNurseskill;
use App\Models\forms\FormNursetypework;
use App\Models\forms\FormNurseworklocation;

use App\Models\client\Client_baby;
use App\Models\client\Client_agegroup;
use App\Models\client\Client_dutie;
use App\Models\client\Client_joboption;

use App\Models\client\Client_keeper;
use App\Models\client\Client_keeperdutie;
use App\Models\client\Client_keeperjoboption;

use App\Models\client\Client_nurse;
use App\Models\client\Client_nursedutie;
use App\Models\client\Client_nursejoboption;

class HelpController extends Controller
{
    public function getAdmin ()
    {
        //$admin = User::where('role', 'Администратор')->value('id')->first();
        $admin = User::select('id')->where('role', 'Администратор')->first();
        return $admin;
    }
    public function getMessage_in (Request $request)
    {
        $messages = Message::where('recipient', $request["data"])->get();            
        return $messages;
    }
    public function redisAll ()
    {
        Cache::put('client_nurses', Client_nurse::all());
        Cache::put('client_nurseduties', Client_nursedutie::all());
        Cache::put('client_nursejoboptions', Client_nursejoboption::all());

        Cache::put('client_keepers', Client_keeper::all());
        Cache::put('client_keeperduties', Client_keeperdutie::all());
        Cache::put('client_keeperjoboptions', Client_keeperjoboption::all());

        Cache::put('client_babies', Client_baby::all());
        Cache::put('client_agegroups', Client_agegroup::all());
        Cache::put('client_duties', Client_dutie::all());
        Cache::put('client_joboptions', Client_joboption::all());

        Cache::put('nurses', Nurse::all());
        Cache::put('formnurseduties', FormNursedutie::all());
        Cache::put('formnurseeducations', FormNurseeducation::all());
        Cache::put('formnursejoboptions', FormNursejoboption::all());
        Cache::put('formnurseskills', FormNurseskill::all());
        Cache::put('formnursetypeworks', FormNursetypework::all());
        Cache::put('formnurseworklocation', FormNurseworklocation::all());

        Cache::put('keepers', Keeper::all());
        Cache::put('formkeeperduties', FormKeeperdutie::all());
        Cache::put('formkeeperjoboptions', FormKeeperjoboption::all());
        Cache::put('formkeeperpreferences', FormKeeperpreference::all());
        Cache::put('formkeepertypeworks', FormKeepertypework::all());

        Cache::put('formtypeworks', FormTypework::all());
        Cache::put('userlanguages', UserLanguages::all());
        Cache::put('formagegroups', FormAgegroup::all());
        Cache::put('formdiagnoses', FormDiagnose::all());
        Cache::put('formduties', FormDutie::all());
        Cache::put('formeducations', FormEducation::all());
        Cache::put('formjoboptions', FormJoboption::all());
        Cache::put('babies', Baby::all());        
        
        Cache::put('credentials', Credential::all());
        Cache::put('users', User::all()); 
        Cache::put('images', Image::all());
        Cache::put('messages', Message::all());
    }
    
    public function redisShow ()
    {  
        $getUsers = Cache::get('users');
        
        foreach ($getUsers as $user) {
            if($user->name = 'Дима') {
                return $user;
            }                           
        }        
    }

    public function RedisOne ($id)
    { 
        //$user = Cache::get('users:all');
        //return $user;

        // Добавление либо изменение одного обьекта
        //$newuser = 'Созданный обьект';
        //Cache::put('users:' . $id, $newuser);

        // Удаление одного обьекта
        //Cache::forget('users:' . $id);

        // Получение одного обьекта
        //$user = Cache::get('users:' . $id);
        //return $user;
    } 

    public function test(Request $request)
    {
        $page = $request->input('page', 0);
        $perPage = $request->input('per_page', 10);

        $cacheTag = 'users';
        $cacheKey = 'users.all.page' . $page . 'per_page' . $perPage;
        $cacheTTL = 3600;

        if (Cache::tags($cacheTag)->has($cacheKey)) {
            $jsonData = Cache::tags($cacheTag)->get($cacheKey);
            Log::debug("Get From Cache");
            return response()->json($jsonData);
            }
        else {
            $usersPaginator = User::paginate($perPage);
            Log::debug("Put to Cache");
            Log::debug($usersPaginator);
            Cache::tags($cacheTag)->put($cacheKey, $usersPaginator, $cacheTTL);
            return response()->json($usersPaginator);
        }
    }
}
