<?php

namespace App\Http\Controllers\Resource;

use App\Fleet;
use App\Promocode;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PromocodeResource extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('demo', ['only' => ['store' ,'update', 'destroy']]);
        $this->middleware('permission:promocodes-list', ['only' => ['index']]);
        $this->middleware('permission:promocodes-create', ['only' => ['create','store']]);
        $this->middleware('permission:promocodes-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:promocodes-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promocodes = Promocode::orderBy('created_at' , 'desc')->get();
        return view('admin.promocode.index', compact('promocodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fleets = Fleet::all();
        return view('admin.promocode.create', compact('fleets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'fleet_id'   => 'required',
            'promo_code' => 'required|max:100|unique:promocodes',
            'percentage' => 'required|numeric',
            'max_amount' => 'required|numeric',
            'expiration' => 'required',
        ]);

        $request['expiration'] = date("Y-m-d", strtotime( str_replace("/", "-", explode(' ', $request["expiration"])[0] ) ) ) . ' ' . explode(' ', $request["expiration"])[1];


        try{
            Promocode::create($request->all());
            return redirect()->route('admin.fleet.show',  $request->fleet_id )->with('flash_success', trans('admin.promocode_msgs.promocode_saved'));

        }

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('admin.promocode_msgs.promocode_not_found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promocode  $promocode
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return Promocode::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promocode  $promocode
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $fleets = Fleet::all();
            $promocode = Promocode::findOrFail($id);
            return view('admin.promocode.edit',compact('promocode','fleets'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promocode  $promocode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'fleet_id'   => 'required',
            'promo_code' => 'required|max:100',
            'percentage' => 'required|numeric',
            'max_amount' => 'required|numeric',
            'expiration' => 'required',
        ]);

         $request['expiration'] = date("Y-m-d", strtotime( str_replace("/", "-", explode(' ', $request["expiration"])[0] ) ) ) . ' ' . explode(' ', $request["expiration"])[1];

        try {

           $promo = Promocode::findOrFail($id);
           
            $promo->fleet_id = $request->fleet_id;
            $promo->promo_code = $request->promo_code;
            $promo->percentage = $request->percentage;
            $promo->max_amount = $request->max_amount;
            $promo->expiration = $request->expiration;
            $promo->promo_description = $request->promo_description;
            $promo->save();

            return redirect()->route('admin.fleet.show',  $promo->fleet_id )->with('flash_success', trans('admin.promocode_msgs.promocode_update'));
        }

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('admin.promocode_msgs.promocode_not_found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promocode  $promocode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Promocode::find($id)->delete();
            return back()->with('flash_success', trans('admin.promocode_msgs.promocode_delete'));
        }
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('admin.promocode_msgs.promocode_not_found'));
        }
    }
}
