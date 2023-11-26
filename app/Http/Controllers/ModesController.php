<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
class ModesController extends Controller
{
    private $appUtilities;
    private $getAppliances;
    /**
     * ModesController constructor.
     *
     * @param AppUtilities $appUtilities The AppUtilities instance.
     * @param AppliancesController $getAppliances The AppliancesController instance.
     */
    public function __construct(AppUtilities $appUtilities, AppliancesController $getAppliances)
    {
        $this->appUtilities = $appUtilities;
        $this->getAppliances = $getAppliances;
    }

    public function index(){
        $user = auth()->user();
        $homeData = $this->appUtilities->findHomeData($user);
        $modes = DB::table('modes')->where('home_id',$homeData->id)->get();
        $appliances = $this->getAppliances->getAppliances($homeData);
        if(empty($modes[0])){
            $modes = null;
        };
        return Inertia::render('Modes/Main',
        [
            'homeData' => $homeData,
            'modes' => $modes,
            'devices' => $appliances
        ]);
    }

    /**
     * Create a new mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function createMode(Request $request){
        $request -> validate([
            'mode_name' => 'required | string | max:20',
        ]);
        $user = auth()->user();
        $homeData = $this->appUtilities->findHomeData($user);
        DB::table('modes')->insert([
            'home_id' => $homeData->id,
            'mode_name' => $request->mode_name, 
            'created_by' => $user->id,
            'created_at' => now()
        ]);
    }
    /**
     * Update the mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function editMode(Request $request){
        $request -> validate([
            'mode_id' => 'required | integer',
            'mode_name' => 'required | string | max:20',
        ]);
        DB::table('modes')->where('id',$request->mode_id)->update([
            'mode_name' => $request->mode_name,
            'updated_at' => now()
        ]);
    }

    /**
     * Delete a mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function deleteMode(Request $request){
        $request -> validate([
            'mode_id' => 'required | integer',
        ]);
        DB::table('modes')->where('id',$request->mode_id)->delete();
    }
}
