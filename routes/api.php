<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    Route::post('register', 'App\Http\Controllers\Api\RegisterController@register');
    Route::post('login', 'App\Http\Controllers\Api\RegisterController@login');

    Route::middleware('auth:sanctum')->group( function () {
         // UTILITY MODULE ADD EDIT UPDATE END DELETE
        Route::get('GetUtilityLisiting', 'App\Http\Controllers\Api\AppBaseController@GetUtilityLisiting');
        Route::get('UtilityGet/{id}', 'App\Http\Controllers\Api\AppBaseController@UtilityGet');
        Route::post('UtilityAdd', 'App\Http\Controllers\Api\AppBaseController@UtilityAdd');
        Route::put('UtiliyUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@UtiliyUpdate');
        Route::delete('UtiliyDelete/{id}', 'App\Http\Controllers\Api\AppBaseController@UtiliyDelete');
        //UtilitySubCategories
        Route::get('GetUtiltiSubCategoriesList', 'App\Http\Controllers\Api\AppBaseController@GetUtiltiSubCategoriesList');
        Route::post('UtiltiSubCategoriesAdd', 'App\Http\Controllers\Api\AppBaseController@UtiltiSubCategoriesAdd');
        Route::get('UtiltiSubCategoriesSingleGet/{id}', 'App\Http\Controllers\Api\AppBaseController@UtiltiSubCategoriesSingleGet'); 
        Route::put('UtiltiSubCategoriesUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@UtiltiSubCategoriesUpdate');
        Route::delete('UtiltiSubCategoriesDelete/{id}', 'App\Http\Controllers\Api\AppBaseController@UtiltiSubCategoriesDelete');
        // UTILITY REPORT UPLOAD
        Route::get('GetUtiltiReportUploadQuery/{date}', 'App\Http\Controllers\Api\AppBaseController@GetUtiltiReportUploadQuery');
        Route::post('GetUtiltiReportUploadQueryAdd', 'App\Http\Controllers\Api\AppBaseController@GetUtiltiReportUploadQueryAdd');
        Route::put('GetUtiltiReportUploadQueryUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@GetUtiltiReportUploadQueryUpdated');
        // UTLITY REPORT VIEW DATE 
        Route::get('ViewReportUtilityDateSerch/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportUtilityDateSerch');
        //  UTLITY REPORT MACHIN VIEW
        Route::get('ViewReportUtilityDateSerchMainCategories/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportUtilityDateSerchMainCategories');
        // MACHINE MODULE ADD EDIT EDIT START DELETE
        Route::get('GetMachineCategoriesListing', 'App\Http\Controllers\Api\AppBaseController@GetMachineCategoriesListing');
        Route::post('MachineCategoriesAdd', 'App\Http\Controllers\Api\AppBaseController@MachineCategoriesAdd');
        Route::put('MachineCategoriesUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@MachineCategoriesUpdated');
        Route::delete('MachineCategoriesDelated/{id}', 'App\Http\Controllers\Api\AppBaseController@MachineCategoriesDelated');
        // MACHIN SUB CATEGORIEES ADD EDIT UPDATE 
        Route::get('GetMachineSubCategoriesListing', 'App\Http\Controllers\Api\AppBaseController@GetMachineSubCategoriesListing');
        Route::post('MachineSubCategoriesAdd', 'App\Http\Controllers\Api\AppBaseController@MachineSubCategoriesAdd');
        Route::put('MachineSubCategoriUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@MachineSubCategoriUpdated');
        Route::delete('MachineSubCategoriesDelated/{id}', 'App\Http\Controllers\Api\AppBaseController@MachineSubCategoriesDelated');
        // MACHINE UPLOAD ADD
        Route::get('GetMachineReportUploadQuery/{date}', 'App\Http\Controllers\Api\AppBaseController@GetMachineReportUploadQuery');
        Route::post('MachineReportUpload', 'App\Http\Controllers\Api\AppBaseController@MachineReportUpload');
        Route::put('MachineReportUploadUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@MachineReportUploadUpdated');
        // MACHIN VIEW REPORT DATE 
        Route::get('ViewReportMachineDateSearch/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportMachineDateSearch');
        // MAIN MACHIN REPORT VIEW 
        Route::get('ViewReportMachineDateSearchMainCategories/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportMachineDateSearchMainCategories');
        // GEB REPORT ADD 
        Route::post('GebAdd', 'App\Http\Controllers\Api\AppBaseController@GebAdd');
        Route::get('GetGebListing', 'App\Http\Controllers\Api\AppBaseController@GetGebListing');
        Route::put('GebUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@GebUpdated');
        Route::delete('DeleteGeb/{id}', 'App\Http\Controllers\Api\AppBaseController@DeleteGeb');
         // UplodeReportGeb
        Route::get('UploadReportGebSharch/{date}', 'App\Http\Controllers\Api\AppBaseController@UploadReportGebSharch');
        Route::post('UploadReportGebAdd', 'App\Http\Controllers\Api\AppBaseController@UploadReportGebAdd');
        Route::put('UploadReportGebUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@UploadReportGebUpdate');
         // GEB VIEW REPORT
        Route::get('ViewReportGebDateSearch/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportGebDateSearch'); 
        // Thermopack ADD EDIT UPDATE
        Route::post('ThermoopackAdd', 'App\Http\Controllers\Api\AppBaseController@ThermoopackAdd');
        Route::get('ThermopackListing', 'App\Http\Controllers\Api\AppBaseController@ThermopackListing');
        Route::put('ThermoopackUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@ThermoopackUpdated');
        Route::delete('DeletedThermopack/{id}', 'App\Http\Controllers\Api\AppBaseController@DeletedThermopack');
         //Thermopack ReportUpload
        Route::get('GetThermopackReportUploadDate/{date}', 'App\Http\Controllers\Api\AppBaseController@GetThermopackReportUploadDate');
        Route::post('GetThermopackReportUploadAdd', 'App\Http\Controllers\Api\AppBaseController@GetThermopackReportUploadAdd');
        Route::put('GetThermopackReportUploadUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@GetThermopackReportUploadUpdated');
         // ViewReportThermopack
        Route::get('ViewReportThermopackDateSearchNew/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportThermopackDateSearchNew');
         // SteamBolier ADD EDIT UPDATE
        Route::get('SteamBolierListing', 'App\Http\Controllers\Api\AppBaseController@SteamBolierListing');
        Route::post('SteamBolierAdd', 'App\Http\Controllers\Api\AppBaseController@SteamBolierAdd');
        Route::put('SteamBolierUpadated/{id}', 'App\Http\Controllers\Api\AppBaseController@SteamBolierUpadated');
        Route::delete('DeletedSteamBolier/{id}', 'App\Http\Controllers\Api\AppBaseController@DeletedSteamBolier');
        //STEAM Bolier ReportUpload
        Route::post('SteamBoliersDataAdd', 'App\Http\Controllers\Api\AppBaseController@SteamBoliersDataAdd');
        Route::get('GetSteamBoliersDataQuery/{date}', 'App\Http\Controllers\Api\AppBaseController@GetSteamBoliersDataQuery');
        Route::put('GetSteamBoliersDataQueryUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@GetSteamBoliersDataQueryUpdated');
          // Steam Bolier View Report
        Route::get('ViewReportSteamBoilerDateSearchNew/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportSteamBoilerDateSearchNew');
        //Water Quilty ADD EDIT UPDATE
        Route::get('GetWaterQualityLisiting', 'App\Http\Controllers\Api\AppBaseController@GetWaterQualityLisiting');
        Route::post('WaterQualityAdd', 'App\Http\Controllers\Api\AppBaseController@WaterQualityAdd');
        Route::put('WaterQualityUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@WaterQualityUpdate');
        Route::delete('WaterQualityDelete/{id}', 'App\Http\Controllers\Api\AppBaseController@WaterQualityDelete');
         // Water Quality Report Upload
        Route::post('GetWaterQualityReportUploadAdd', 'App\Http\Controllers\Api\AppBaseController@GetWaterQualityReportUploadAdd');
        Route::put('GetWaterQualityReportUploadUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@GetWaterQualityReportUploadUpdated');
        Route::get('GetWaterQualityReportDateSearch/{date}', 'App\Http\Controllers\Api\AppBaseController@GetWaterQualityReportDateSearch');
        // Water Quality
        Route::get('ViewReportWaterQualityDateSearch/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportWaterQualityDateSearch');
         //SupplyPump ADD EDIT UPDATE
        Route::get('GetSupplyPumpListing', 'App\Http\Controllers\Api\AppBaseController@GetSupplyPumpListing');
        Route::post('GetSupplyPumpDataAdd', 'App\Http\Controllers\Api\AppBaseController@GetSupplyPumpDataAdd');
        Route::put('GetSupplyPumpDataUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@GetSupplyPumpDataUpdated');
        Route::delete('GetSupplyPumpDataDeleted/{id}', 'App\Http\Controllers\Api\AppBaseController@GetSupplyPumpDataDeleted');
        //  SUPPLYPPUMP REPORT ADD
        Route::get('GetSupplyPumpReportUploadListing', 'App\Http\Controllers\Api\AppBaseController@GetSupplyPumpReportUploadListing');
        Route::post('GetSupplyPumpReportUploadAdd', 'App\Http\Controllers\Api\AppBaseController@GetSupplyPumpReportUploadAdd');
        Route::get('GetSupplyPumpReportUploadDateSerch/{date}', 'App\Http\Controllers\Api\AppBaseController@GetSupplyPumpReportUploadDateSerch');
        Route::put('SupplyPumpReportUploadUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@SupplyPumpReportUploadUpdated');
         // SUPPLYPUMP REPORT VIEW
        Route::get('ViewReportSupplyPumpDateSearch/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportSupplyPumpDateSearch');
        //Misc ADD EDIT UPDATE
        Route::get('MiscLisiting', 'App\Http\Controllers\Api\AppBaseController@MiscLisiting');  
        Route::post('MiscAdd', 'App\Http\Controllers\Api\AppBaseController@MiscAdd');
        Route::put('MiscUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@MiscUpdate');
        Route::delete('MiscDelete/{id}', 'App\Http\Controllers\Api\AppBaseController@MiscDelete');
        //MiscReportUpload.
        Route::get('MiscReportUploadSharch/{date}', 'App\Http\Controllers\Api\AppBaseController@MiscReportUploadSharch');
        Route::get('MiscReportUploadSharchh/{date}/{machine_id}', 'App\Http\Controllers\Api\AppBaseController@MiscReportUploadSharchh');
        Route::post('MiscReportUploadAdd', 'App\Http\Controllers\Api\AppBaseController@MiscReportUploadAdd');
        Route::put('MiscReportUploadUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@MiscReportUploadUpdate');
        // MISC ViewReport
        Route::get('ViewReportMiscDateSearch/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportMiscDateSearch');
        //Mano meter Thermopack
        Route::get('ManoMeterThermopackLisiting', 'App\Http\Controllers\Api\AppBaseController@ManoMeterThermopackLisiting');    
        Route::post('ManoMeterThermopackAdd', 'App\Http\Controllers\Api\AppBaseController@ManoMeterThermopackAdd');
        Route::put('ManoMeterThermopackUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@ManoMeterThermopackUpdate');
        Route::delete('ManoMeterThermopackDelete/{id}', 'App\Http\Controllers\Api\AppBaseController@ManoMeterThermopackDelete');
        //ManoMeterThermopackReportUpload.
        Route::get('ManoMeterThermopackReportUploadSharch/{date}', 'App\Http\Controllers\Api\AppBaseController@ManoMeterThermopackReportUploadSharch');
        Route::post('ManoMeterThermopackReportUploadAdd', 'App\Http\Controllers\Api\AppBaseController@ManoMeterThermopackReportUploadAdd');
        Route::put('ManoMeterThermopackReportUploadUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@ManoMeterThermopackReportUploadUpdate');
        // MenoMetor Thermopack view
        Route::get('ViewReportMenoMeterDateSearch/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportMenoMeterDateSearch');

        //Mano meter Steam Boiller
        Route::get('ManoMeterSteamBoilerLisiting', 'App\Http\Controllers\Api\AppBaseController@ManoMeterSteamBoilerLisiting');
        Route::post('ManoMeterSteamBoilerAdd', 'App\Http\Controllers\Api\AppBaseController@ManoMeterSteamBoilerAdd');
        Route::put('ManoMeterSteamBoilerUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@ManoMeterSteamBoilerUpdate');
        Route::delete('ManoMeterSteamBoilerDelete/{id}', 'App\Http\Controllers\Api\AppBaseController@ManoMeterSteamBoilerDelete');
        //ManoMeterSteamBoilerReportUpload
        Route::get('ManoMeterSteamBoilerReportUploadSharch/{date}', 'App\Http\Controllers\Api\AppBaseController@ManoMeterSteamBoilerReportUploadSharch');
        Route::post('ManoMeterSteamBoilerReportUploadAdd', 'App\Http\Controllers\Api\AppBaseController@ManoMeterSteamBoilerReportUploadAdd');
        Route::put('ManoMeterSteamBoilerReportUploadUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@ManoMeterSteamBoilerReportUploadUpdate');
        // MenoMetor Steambolier 
        Route::get('ViewReportMenoMeterSteambolierDateSearch/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportMenoMeterSteambolierDateSearch');
        //flueGasSteamBolie
        Route::get('GetFlueGasSteamBolierListingData', 'App\Http\Controllers\Api\AppBaseController@GetFlueGasSteamBolierListingData');
        Route::post('GetFlueGasSteamBolierListingDataAdd', 'App\Http\Controllers\Api\AppBaseController@GetFlueGasSteamBolierListingDataAdd');
        Route::put('GetFlueGasSteamBolierListingDataUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@GetFlueGasSteamBolierListingDataUpdated');
        Route::delete('GetFlueGasSteamBolierListingDataDelete/{id}', 'App\Http\Controllers\Api\AppBaseController@GetFlueGasSteamBolierListingDataDelete'); 
        //FlueGasSteamBoilerReportUpload
        Route::get('FlueGasSteamBoilerReportUploadSharch/{date}', 'App\Http\Controllers\Api\AppBaseController@FlueGasSteamBoilerReportUploadSharch');
        Route::post('FlueGasSteamBoilerReportUploadAdd', 'App\Http\Controllers\Api\AppBaseController@FlueGasSteamBoilerReportUploadAdd');
        Route::put('FlueGasSteamBoilerReportUploadUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@FlueGasSteamBoilerReportUploadUpdate');
         // Flue GAS REPORT VIEW STEAM BOLIER
        Route::get('ViewReportFlueGasSteamBolierDateSearch/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportFlueGasSteamBolierDateSearch');

        // GetFlueGasThermoPack
        Route::get('GetFlueGasThermoPackListingData', 'App\Http\Controllers\Api\AppBaseController@GetFlueGasThermoPackListingData');
        Route::post('GetFlueGasThermoPackListingDataAdd', 'App\Http\Controllers\Api\AppBaseController@GetFlueGasThermoPackListingDataAdd');
        Route::put('GetFlueGasThermoPackListingDataUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@GetFlueGasThermoPackListingDataUpdated');
        Route::delete('GetFlueGasThermoPackListingDelete/{id}', 'App\Http\Controllers\Api\AppBaseController@GetFlueGasThermoPackListingDelete');
        //FlueGasThermoPackReportUpload
        Route::get('FlueGasThermoPackReportUploadSearch/{date}', 'App\Http\Controllers\Api\AppBaseController@FlueGasThermoPackReportUploadSearch');
        Route::post('FlueGasThermoPackReportUploadAdd', 'App\Http\Controllers\Api\AppBaseController@FlueGasThermoPackReportUploadAdd');
        Route::put('FlueGasThermoPackReportUploadUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@FlueGasThermoPackReportUploadUpdate');
        // Flue GAS REPORT VIEW THERMOPACK 
        Route::get('ViewReportFlueGasThermopackDateSearch/{date}', 'App\Http\Controllers\Api\AppBaseController@ViewReportFlueGasThermopackDateSearch');
    
        // ToDoList
        Route::get('GetToDoListDataListing', 'App\Http\Controllers\Api\AppBaseController@GetToDoListDataListing');
        Route::post('GetToDoListDataAdd', 'App\Http\Controllers\Api\AppBaseController@GetToDoListDataAdd');
        Route::put('GetToDoListDataAddUpdated/{id}', 'App\Http\Controllers\Api\AppBaseController@GetToDoListDataAddUpdated');
        Route::delete('GetToDoListDataDelete/{id}', 'App\Http\Controllers\Api\AppBaseController@GetToDoListDataDelete');
        //UserPorfile
        Route::put('ProfileUpdate/{id}', 'App\Http\Controllers\Api\AppBaseController@ProfileUpdate');
        Route::get('GetProfileshow', 'App\Http\Controllers\Api\AppBaseController@GetProfileshow');
        Route::post('upsertData', 'App\Http\Controllers\Api\AppBaseController@upsertData');




        Route::post('/logout', 'App\Http\Controllers\Api\AppBaseController@logout');   


    });



    
      