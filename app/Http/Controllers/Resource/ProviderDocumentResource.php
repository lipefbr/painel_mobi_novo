<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SendPushNotification;

use DB;
use Exception;
use Setting;

use App\Provider;
use App\ServiceType;
use App\ProviderService;
use App\ProviderDocument;
use App\Fleet;
use App\Helpers\Helper;

class ProviderDocumentResource extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:provider-service-update', ['only' => ['store']]);
        $this->middleware('permission:provider-service-delete', ['only' => ['service_destroy']]);
        $this->middleware('permission:provider-document-edit', ['only' => ['update']]);
        $this->middleware('permission:provider-document-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $provider)
    {
        try {
            $backurl=$request->session()->get('providerpage');
            $Provider = Provider::findOrFail($provider);
            $ProviderService = ProviderService::where('provider_id',$provider)->with('service_type')->get();
            $ProviderFleet = Fleet::where("city_id", $Provider->city_id)->first();
            //            $ServiceTypes = ServiceType::all();
            $ServiceTypes = ServiceType::where('fleet_id', $Provider->fleet)->get();
            return view('admin.providers.document.index', compact('Provider', 'ServiceTypes','ProviderService', 'ProviderFleet', 'backurl'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $provider)
    {
        $this->validate($request, [
                'service_type' => 'required|exists:service_types,id',
                'service_number' => 'required',
                'service_model' => 'required',
            ]);
        

        try {
            //Alterado por Allan
            if($request->method == "update"){
                $ProviderService = ProviderService::where('provider_id', $provider)->where('service_type_id', $request->service_type)->firstOrFail();
                $ProviderService->update([
                        'service_type_id' => $request->service_type,
                        'status' => 'active',
                        'service_number' => $request->service_number,
                        'service_model' => $request->service_model,
                    ]);
            }else{
                $Provider = Provider::where('id', $provider)->first();
                $ProviderFleet = ServiceType::where('id', $request->service_type)->where('fleet_id', $Provider->fleet)->first();
                if($ProviderFleet){
                     ProviderService::create([
                        'provider_id' => $provider,
                        'service_type_id' => $request->service_type,
                        'status' => 'active',
                        'service_number' => $request->service_number,
                        'service_model' => $request->service_model,
                    ]);
                }else{
                    return back()->with('flash_error', "O servi??o n??o pertence a cidade de cadastro do motorista. Por favor, selecione um servi??o da mesma franquia do motorista.");
                }
            }
            

            // Sending push to the provider
            (new SendPushNotification)->DocumentsVerfied($provider);

        } catch (ModelNotFoundException $e) {
            $Provider = Provider::where('id', $provider)->first();
            $ProviderFleet = ServiceType::where('id', $request->service_type)->where('fleet_id', $Provider->fleet)->first();
                if($ProviderFleet){
                     ProviderService::create([
                    'provider_id' => $provider,
                    'service_type_id' => $request->service_type,
                    'status' => 'offline',
                    'service_number' => $request->service_number,
                    'service_model' => $request->service_model,
                ]);
                }else{
                    return back()->with('flash_error', "O servi??o n??o pertence a cidade de cadastro do motorista. Por favor, selecione um servi??o da mesma franquia do motorista.");
                }
        }
        if($request->method == "update"){
            return back()->with('flash_success', trans('admin.provider_msgs.provider_service_update'));
        }

        return back()->with('flash_success', 'Servi??o atribu??do com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($provider, $id)
    {
        try {
            $Document = ProviderDocument::where('provider_id', $provider)
                ->findOrFail($id);

            return view('admin.providers.document.edit', compact('Document'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $provider, $id)
    {
        try {
            $Document = ProviderDocument::where('provider_id', $provider)
                ->findOrFail($id);
            $Document->update(['status' => 'ACTIVE']);

            return redirect()
                ->back()
                ->with('flash_success', trans('admin.provider_msgs.document_approved'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->back()
                ->with('flash_error', trans('admin.provider_msgs.document_not_found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($provider, $id)
    {
        try {
            
            $Document = ProviderDocument::findOrFail($id);
            $Document->delete();
            
            Provider::where('id', $provider)->update(['status' => 'document']);

            return redirect()
                ->back()
                ->with('flash_success', trans('admin.provider_msgs.document_delete'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->back()
                ->with('flash_error', trans('admin.provider_msgs.document_not_found'));
        }
    }

    /**
     * Delete the service type of the provider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function service_destroy(Request $request, $provider, $id)
    {
        try {

            $ProviderService = ProviderService::where('provider_id', $provider)->where('id', $id)->firstOrFail();
            $ProviderService->delete();            

            return back()->with('flash_success', trans('admin.provider_msgs.provider_service_delete'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('admin.provider_msgs.provider_service_not_found'));
        }
    }   

}
