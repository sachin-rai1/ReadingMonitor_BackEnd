<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UtilityCategories;
use App\Models\UtilitySubCategories;
use App\Models\UtilityAvarege;
use App\Models\Geb;
use App\Models\Thermpack;
use App\Models\SteamBoiler;
use App\Models\MachineCategories;
use App\Models\MachineSubCategories;
use App\Models\MachineAvarage;
use App\Models\SupplyPump;
use App\Models\FlueGasSteamBoliers;
use App\Models\FlueGasSteamBoilerReportUpload;
use App\Models\FlueGasThermoPack;
use App\Models\FlueGasThermoPackReportUpload;
use App\Models\ToDoList;
use App\Models\SteamBolierReportUpload;
use App\Models\MachineReportUpload;
use App\Models\UtilitReportUpload;
use App\Models\ThermopackReportUpload;
use App\Models\SupplyPumpReportUploard;
use App\Models\WaterQualityReportUploard;
use App\Models\WaterQuilty;
use App\Models\Misc;
use App\Models\MiscReportUpload;
use App\Models\GebReportUpload;
use App\Models\ManoMeterThermopack;
use App\Models\ManoMeterThermopackReportUpload;
use App\Models\ManoMeterSteamBoiler;
use App\Models\ManoMeterSteamBoilerReportUpload;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class AppBaseController extends Controller
{
    // STAR ULITY MAIN ADD EDIT UPDATE AND DELETE
    public function GetUtilityLisiting()
    { 
        $id =  auth()->user()->id;
        $Utlity = UtilityCategories::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($Utlity, 200);
    }
    public function UtilityAdd(Request $request)
    {
      $user = auth()->user();
      $user_id = auth()->user()->id;
      $Utlity = new UtilityCategories;
      $Utlity->user_id =$user->id;
      $Utlity->uitility_categories = $request->uitility_categories;
      $Utlity->save();

      return response()->json([
        "message" => "Utility Categories record created"
      ], 200);

    }
    public function UtilityGet($id)
    {
        if (UtilityCategories::where('id', $id)->exists()) {
            $Utlity = UtilityCategories::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($Utlity, 200);
          } else {
            return response()->json([
              "message" => "Utility Categories not found"
            ], 404);
          }
    }
    public function UtiliyUpdate(Request  $request,$id)
    {
        $Utlity = UtilityCategories::find($request->id);
        $Utlity -> uitility_categories = $request -> uitility_categories;
        $result = $Utlity -> save();
        if($result){
            return["Result"=>" Utility Categories been Update"];
        }
        else{
            return["Result"=>"Update operation has been failed"];
        }
    }
    public function UtiliyDelete($id)
    {
        if(UtilityCategories::where('id', $id)->exists()) {
            $Utlity = UtilityCategories::find($id)->delete();
            $Utlity = UtilitySubCategories::where('uitility_categories_id',$id)->delete();
            $Utlity = UtilitReportUpload::where('uitility_categories_id',$id)->delete();
            // $Utlity->delete();
    
            return response()->json([
              "message" => " Utility Categories records deleted"
            ], 200);
          } else {
            return response()->json([
              "message" => "Utility Categories not found"
            ], 404);
          }
    }
    // END ULITY MAIN ADD EDIT UPDATE AND DELTE
    // SUB UTLITY CATEGORIES START 

    public function GetUtiltiSubCategoriesList()
    {
        $id =  auth()->user()->id;
        $UtlitySub = UtilitySubCategories::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($UtlitySub, 200);
    }
    public function UtiltiSubCategoriesAdd(Request $request)
    {   
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $UtlitySub = new UtilitySubCategories;
        $UtlitySub->user_id = $user->id;
        $UtlitySub->uilitysubc_name = $request->uilitysubc_name;
        $UtlitySub->uitility_categories_id   = $request->uitility_categories_id;
        $UtlitySub->average  = $request->average;
        $UtlitySub->deviation = $request->deviation;
        $UtlitySub->save();
  
        return response()->json([
          "message" => "Utility SubCategories record created"
        ], 200);
    }
    public function UtiltiSubCategoriesSingleGet($id)
    {
        if (UtilitySubCategories::where('id', $id)->exists()) {
            $UtlitySub = UtilitySubCategories::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($UtlitySub, 200);
          } else {
            return response()->json([
              "message" => "Utility SubCategories not found"
            ], 404);
          }

    }
    public function UtiltiSubCategoriesUpdate(Request $request, $id)
    {
        $UtlitySub = UtilitySubCategories::find($request->id);
        $UtlitySub -> uilitysubc_name = $request -> uilitysubc_name;
        $UtlitySub->average  = $request->average;
        $UtlitySub->deviation        = $request->deviation;
        $result = $UtlitySub -> save();
        if($result){
            return["Result"=>" Utility SubCategories been Update"];
        }
        else{
            return["Result"=>"Update operation has been failed"];
        }
    }

    public function UtiltiSubCategoriesDelete($id)
    {
        if(UtilitySubCategories::where('id', $id)->exists()) {
            $UtlitySub = UtilitySubCategories::find($id);
            $UtlitySub->delete();
    
            return response()->json([
              "message" => " Utility Sub Categories records deleted"
            ], 200);
          } else {
            return response()->json([
              "message" => "Utility Categories not found"
            ], 404);
          }
    }
    // SUB UTILITY CATEGORIES END

    // ULITY UPLOAD REPORT STAR 
    public function GetUtiltiReportUploadQuery($date)
    {
      $id =  auth()->user()->id;
       $UtilitReportUpload = UtilitReportUpload::where('date',$date)
       ->where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
       return response($UtilitReportUpload, 200);
    }
    public function GetUtiltiReportUploadQueryAdd(Request $request)
    {
     $user = auth()->user();
     $user_id = auth()->user()->id;
     $UtilitReportUpload = new UtilitReportUpload;
     $UtilitReportUpload->user_id =$user->id;
     $UtilitReportUpload->uitility_categories_id = $request->uitility_categories_id;
     $UtilitReportUpload->uitility_subcategories_id     = $request->uitility_subcategories_id;
     $UtilitReportUpload->date = $request->date;
     $UtilitReportUpload->em    = $request->em;
     $UtilitReportUpload->hm = $request->hm;
     $UtilitReportUpload->save();

     return response()->json([
       "message" => "Utitlity  Report Upload  record created"
     ], 200);
    }
    public function GetUtiltiReportUploadQueryUpdated(Request $request,$id)
    {
     $UtilitReportUpload = UtilitReportUpload::find($request->id);
     $UtilitReportUpload->em    = $request->em;
     $UtilitReportUpload->hm = $request->hm;
     $result = $UtilitReportUpload ->save();
     if($result){
         return["Result"=>"Utitlity  Report Upload Has been Update"];
     }
     else{
         return["Result"=>"Update operation has been failed"];
     }

    }
    // UTILITY UPLOAD REPORT END

    public function ViewReportUtilityDateSerch($date)
    { 
    //   $user_id =  auth()->user()->id;
    //   $ViewReportUtility = DB::select("SELECT
    //   ifnull((j.em - j.em1),0) em,
    //   ifnull((j.hm - j.hm1),0) hm,
    //   ifnull(round((j.em - j.em1) / (j.hm - j.hm1),2),0) as average,
      

    //   round((((j.em - j.em1) / (j.hm - j.hm1) / (select c.average from tbl_uitility_subcategories c where c.id=j.SubCategoryId)) * 100) - 100 ,2) as dev,
      
    //   (select c.uitility_categories from tbl_uitility_categories c where c.id=j.CategoryId) as CategoryName,
    //   (select c.uilitysubc_name from tbl_uitility_subcategories c where c.id=j.SubCategoryId) as SubCategoryName
       
    //   from (
    //     SELECT 
    //     u.id as TrId,u.user_id as userid , u.date as TrDate, u.uitility_categories_id as CategoryId, u.uitility_subcategories_id as SubCategoryId, u.em as em, u.hm,
    //     ifnull((select us.em from tbl_utility_report_upload us where us.date < u.date and us.uitility_subcategories_id=u.uitility_subcategories_id order by id desc limit 1),0) as em1,
    //     ifnull((select us.hm from tbl_utility_report_upload us where us.date < u.date and us.uitility_subcategories_id=u.uitility_subcategories_id order by id desc limit 1),0) as hm1
    //     From tbl_utility_report_upload u 
    //     inner join tbl_uitility_categories j
    //     inner join tbl_uitility_subcategories k
    //   where u.date=?  and u.user_id = $user_id 
    //   ) as j",[$date]);
    //   return response($ViewReportUtility,200);
      $user_id =  auth()->user()->id;
      $ViewReportUtility = DB::select("SELECT
       ifnull((j.em - j.em1),0) em,
       ifnull((j.hm - j.hm1),0) hm,
       ifnull(round((j.em - j.em1) / (j.hm - j.hm1),2),0) as average,
       
 
        round((((j.em - j.em1) / (j.hm - j.hm1) / (select c.average from tbl_uitility_subcategories c where c.id=j.SubCategoryId)) * 100) - 100 ,2) as dev,
       
       (select c.uitility_categories from tbl_uitility_categories c where c.id=j.CategoryId) as CategoryName,
       (select c.uilitysubc_name from tbl_uitility_subcategories c where c.id=j.SubCategoryId) as SubCategoryName,
        
       (select c.deviation from tbl_uitility_subcategories c where c.id=j.CategoryId) as deviation
        
       from (
         SELECT 
         u.id as TrId,u.user_id as user_id ,u.date as TrDate, u.uitility_categories_id as CategoryId, u.uitility_subcategories_id as SubCategoryId, u.em as em, u.hm,
         ifnull((select us.em from tbl_utility_report_upload us where us.date < u.date and us.uitility_subcategories_id=u.uitility_subcategories_id order by id desc limit 1),0) as em1,
         ifnull((select us.hm from tbl_utility_report_upload us where us.date < u.date and us.uitility_subcategories_id=u.uitility_subcategories_id order by id desc limit 1),0) as hm1
         From tbl_utility_report_upload u 
         join tbl_uitility_categories j on u.uitility_categories_id = j.id
         where u.date=?  and u.user_id = $user_id 
       ) as j",[$date]);
       return response($ViewReportUtility,200);
    }
     // UTLTITY MAIN CATEGORIES 
    public function ViewReportUtilityDateSerchMainCategories($date)
    {
       $user_id =  auth()->user()->id;
      $ViewReportUtilityMain = DB::select("SELECT 
      avg(k.em) as em,
      avg(k.hm) as hm,
      ifnull(round(avg(k.em) / avg(k.hm),2),0) as dev,
      ifnull(round(avg(k.average),2),0) as average,
      ifnull(round(avg(k.devation),2),0) as devation,
      
      k.CategoryId,
      k.uitility_categories
      

      from (
      SELECT
        ifnull((j.em - j.em1),0) em,
        ifnull((j.hm - j.hm1),0) hm,
        
          round((((j.em - j.em1) / (j.hm - j.hm1) / (select c.average from tbl_uitility_subcategories c where c.id=j.SubCategoryId)) * 100) - 100 ,2) as average,
          j.CategoryId,
       
           (select c.uitility_categories from tbl_uitility_categories c where c.id=j.CategoryId) as uitility_categories,
           (select c.deviation from tbl_uitility_subcategories c where c.id=j.SubCategoryId) as devation
           
           
       
      from (
        SELECT 
        u.id as TrId, u.user_id as userid ,u.date as TrDate, u.uitility_categories_id as CategoryId, u.uitility_subcategories_id as SubCategoryId, u.em as em, u.hm,
        ifnull((select us.em from tbl_utility_report_upload us where us.date < u.date and us.uitility_subcategories_id=u.uitility_subcategories_id order by id desc limit 1),0) as em1,
        ifnull((select us.hm from tbl_utility_report_upload us where us.date < u.date and us.uitility_subcategories_id=u.uitility_subcategories_id order by id desc limit 1),0) as hm1
        From tbl_utility_report_upload u 
        inner join tbl_uitility_categories j
        inner join tbl_uitility_subcategories k
        where u.date=?  and u.user_id = $user_id and j.user_id = $user_id and k.user_id = $user_id
      ) as j
      ) k group by k.CategoryId",[$date]);
      return response($ViewReportUtilityMain,200);
    }

    // MACHINE START ADD EDIT UPDATE DELERTE
    public function MachineCategoriesAdd(Request $request)
    {
      $user = auth()->user();
      $user_id = auth()->user()->id;
      $MachineCategories = new MachineCategories;
      $MachineCategories->user_id = $user->id;
      $MachineCategories->categories = $request->categories;
      $MachineCategories->save();

      return response()->json([
        "message" => "Machine Categories record created"
      ], 200);
    }
    public function MachineCategoriesUpdated(Request $request, $id)
    {
        $MachineCategories = MachineCategories::find($request->id);
        $MachineCategories -> categories = $request -> categories;
        $result = $MachineCategories -> save();
        if($result){
            return["Result"=>"Machine Categories been Update"];
        }
        else{
            return["Result"=>"Update operation has been failed"];
        }
    }
    public function MachineCategoriesDelated($id)
    {
      if(MachineCategories::where('id', $id)->exists()) {
        $MachineCategories = MachineCategories::find($id)->delete();
        $MachineCategories =  MachineSubCategories::where('categories_id',$id)->delete();
        $MachineCategories =  MachineReportUpload::where('categories_id',$id)->delete();
        // $MachineCategories->delete();
        return response()->json([
          "message" => " Machine Categories records deleted"
        ], 200);
      } else {
        return response()->json([
          "message" => "Machine Categories not found"
        ], 404);
      }
    }
    public function GetMachineCategoriesListing()
    {
      $id =  auth()->user()->id;
      $MachineCategories = MachineCategories::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
      return response($MachineCategories, 200);
    }
    // MACHIN SUB CATEGORIES
    public function MachineSubCategoriesAdd(Request $request)
    {
      $user = auth()->user();
      $user_id = auth()->user()->id;
      $MachineSubCategories = new MachineSubCategories;
      $MachineSubCategories->categories_id = $request->categories_id;
      $MachineSubCategories->user_id =$user->id;
      $MachineSubCategories->sub_name = $request->sub_name;
      $MachineSubCategories->em_hm = $request->em_hm;
      $MachineSubCategories->em_hm_percentage = $request->em_hm_percentage;
      $MachineSubCategories->water_batch = $request->water_batch;
      $MachineSubCategories->temp_percentage = $request->temp_percentage;
      $MachineSubCategories->save();

      return response()->json([
        "message" => "Machine SubCategories Record created"
      ], 200);

    }
    public function MachineSubCategoriUpdated(Request $request, $id)
    {
      $MachineSubCategories = MachineSubCategories::find($request->id);
      $MachineSubCategories->sub_name = $request->sub_name;
      $MachineSubCategories->em_hm = $request->em_hm;
      $MachineSubCategories->em_hm_percentage = $request->em_hm_percentage;
      $MachineSubCategories->water_batch = $request->water_batch;
      $MachineSubCategories->temp_percentage = $request->temp_percentage;
      $result = $MachineSubCategories -> save();
      if($result){
          return["Result"=>"MachineSubCategories Has been Update"];
      }
      else{
          return["Result"=>"Update operation has been failed"];
      }
    }
    public function GetMachineSubCategoriesListing()
    {
      $id =  auth()->user()->id;
      $MachineSubCategories = MachineSubCategories::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
      return response($MachineSubCategories, 200);

    }
    public function MachineSubCategoriesDelated($id)
    {
      if(MachineSubCategories::where('id', $id)->exists()) {
        $MachineSubCategories = MachineSubCategories::find($id);
        $MachineSubCategories->delete();
        // $MachinAevrage = MachineAvarage::find($id);
        // $MachinAevrage->delete();


        return response()->json([
          "message" => " Machine SubCategories records deleted"
        ], 200);
      } else {
        return response()->json([
          "message" => "Machine SubCategories not found"
        ], 404);
      }
    }
    // MACHIN UPLOAD REPORT ADD 
    public function MachineReportUpload(Request $request)
     {
      $user = auth()->user();
      $user_id = auth()->user()->id;
      $MachineReportUpload = new MachineReportUpload;
      $MachineReportUpload->user_id =$user->id;
      $MachineReportUpload->categories_id = $request->categories_id;
      $MachineReportUpload->sub_categories_id    = $request->sub_categories_id;
      $MachineReportUpload->date = $request->date;
      $MachineReportUpload->water    = $request->water;
      $MachineReportUpload->batch = $request->batch;
      $MachineReportUpload->em   = $request->em;
      $MachineReportUpload->hm = $request->hm;
      $MachineReportUpload->save();

      return response()->json([
        "message" => "Machine  Report Upload  record created"
      ], 200);
     }  
     public function MachineReportUploadUpdated(Request $request,$id)
     {
        $MachineReportUpload = MachineReportUpload::find($request->id);
        $MachineReportUpload->water  = $request->water;
        $MachineReportUpload->batch = $request->batch;
        $MachineReportUpload->em     = $request->em;
        $MachineReportUpload->hm = $request->hm;
        $result = $MachineReportUpload ->save();
        if($result){
            return["Result"=>"Machine  Report Upload Has been Update"];
        }
        else{
            return["Result"=>"Update operation has been failed"];
        }

     }
    
    public function GetMachineReportUploadQuery($date)
     {
        $id =  auth()->user()->id;
        $MachineReportUpload = MachineReportUpload::where('date',$date)
        ->where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($MachineReportUpload, 200);
     }
    //  MAIN MACHINE DATE 
     //  MACHINE REPORT VIEW
      public function ViewReportMachineDateSearch($date)
      {
       $user_id =  auth()->user()->id;
       $ViewReportUtilityMainM = DB::select("SELECT
        ifnull((j.em - j.em1),0) em,
        ifnull((j.hm - j.hm1),0) hm,
        ifnull((j.water - j.water1),0) water,
        -- ifnull((j.batch - j.batch1),0) batch,
        ifnull((j.batch),1) batch,
        ifnull(round((j.em - j.em1) / (j.hm - j.hm1),2),0) as dev,
        
  
        --  round((((j.em - j.em1) / (j.hm - j.hm1)))) as dev,
         round((((j.water - j.water1) / (j.batch) ) ) ) as waterbatch,
         round((((j.water - j.water1) / (j.batch) ))) /  (select c.water_batch from tbl_machine_subcategories c where c.id=j.CategoryId) *100 -100  as weterper,
         round((((j.em - j.em1) / (j.hm - j.hm1) ) ) ) / (select c.em_hm from tbl_machine_subcategories c where c.id=j.CategoryId) *100 -100 as average,
        (select c.categories from tbl_machine_categories c where c.id=j.CategoryId) as CategoryName,
        (select c.sub_name from tbl_machine_subcategories c where c.id=j.SubCategoryId) as SubCategoryName,
        (select c.em_hm_percentage from tbl_machine_subcategories c where c.id=j.SubCategoryId) as em_hm_percentage,
        (select c.temp_percentage	 from tbl_machine_subcategories c where c.id=j.SubCategoryId) as temp_percentage	
         
        from (
          SELECT 
          u.id as TrId,u.user_id as userid, u.date as TrDate, u.categories_id as CategoryId, u.sub_categories_id as SubCategoryId, u.em as em, u.hm,u.water,u.batch,
          ifnull((select us.em from tbl_machine_report_upload us where us.date < u.date and us.sub_categories_id=u.sub_categories_id order by id desc limit 1),0) as em1,
          ifnull((select us.hm from tbl_machine_report_upload us where us.date < u.date and us.sub_categories_id=u.sub_categories_id order by id desc limit 1),0) as hm1,
          ifnull((select us.water from tbl_machine_report_upload us where us.date < u.date and us.sub_categories_id=u.sub_categories_id order by id desc limit 1),0) as water1,
          ifnull((select us.batch from tbl_machine_report_upload us where us.date < u.date and us.sub_categories_id=u.sub_categories_id order by id desc limit 1),0) as batch1
          From tbl_machine_report_upload u 
           join tbl_machine_categories j on u.categories_id = j.id
          where u.date=?  and u.user_id = $user_id 
        ) as j",[$date]);
        return response($ViewReportUtilityMainM,200);
      }
      // MAIN MACHIN 
      public function ViewReportMachineDateSearchMainCategories($date)
     {  
      $user_id =  auth()->user()->id;
       $ViewReportMachineMainCategories = DB::select("SELECT 
       
       ifnull(round(sum(k.em)),0) / count(k.categories) as em,
       avg(k.hm) as hm,
       avg(k.batch) as batch,
       avg(k.waterbatch) as waterbatch,
       avg(k.water) as water,
       ifnull(round(avg(k.em) / avg(k.hm),2),0) as dev,
       avg(k.weterper) as weterper,
       avg(k.average) as average,
        avg(k.em_hm_percentage) as em_hm_percentage,
         avg(k.temp_percentage) as temp_percentage,
  
      
      
          
           
  


       
       k.CategoryId,
       k.categories
       
       
       from (
       SELECT
         ifnull((j.em - j.em1),0) em,
         ifnull((j.hm - j.hm1),0) hm,
         ifnull((j.batch),1) batch,
         ifnull((j.water - j.water1),0) water,
         
           round((((j.water - j.water1) / (j.batch) ))) /  (select c.water_batch from tbl_machine_subcategories c where c.id=j.CategoryId) *100 -100  as weterper,
           round((((j.water - j.water1) / (j.batch) ) ) ) as waterbatch,
 
           round((((j.em - j.em1) / (j.hm - j.hm1) ) ) ) / (select c.em_hm from tbl_machine_subcategories c where c.id=j.CategoryId) *100 -100 as average,
           j.CategoryId,
       
           
          (select c.categories from tbl_machine_categories c where c.id=j.CategoryId) as categories,
           (select c.sub_name from tbl_machine_subcategories c where c.id=j.SubCategoryId) as sub_name,
           (select c.em_hm_percentage from tbl_machine_subcategories c where c.id=j.SubCategoryId) as em_hm_percentage,
           (select c.temp_percentage	 from tbl_machine_subcategories c where c.id=j.SubCategoryId) as temp_percentage	
        
        
       from (
         SELECT 
          u.id as TrId,u.user_id as userid , u.date as TrDate, u.categories_id as CategoryId, u.sub_categories_id as SubCategoryId, u.em as em, u.hm,u.water as water, u.batch as batch,
         ifnull((select us.em from tbl_machine_report_upload us where us.date < u.date and us.sub_categories_id=u.sub_categories_id order by id desc limit 1),0) as em1,
         ifnull((select us.hm from tbl_machine_report_upload us where us.date < u.date and us.sub_categories_id=u.sub_categories_id order by id desc limit 1),0) as hm1,
         ifnull((select us.water from tbl_machine_report_upload us where us.date < u.date and us.sub_categories_id=u.sub_categories_id order by id desc limit 1),0) as water1,
         ifnull((select us.batch from tbl_machine_report_upload us where us.date < u.date and us.sub_categories_id=u.sub_categories_id order by id desc limit 1),0) as batch1
         From tbl_machine_report_upload u 
         inner join tbl_machine_categories j
         inner join tbl_machine_subcategories k
         where u.date=?  and u.user_id = $user_id and j.user_id = $user_id and k.user_id = $user_id
       ) as j
       ) k group by k.CategoryId",[$date]);
       return response($ViewReportMachineMainCategories,200);
     }
    // GEB ADD 
    public function GebAdd(Request $request)
    { 
      $user = auth()->user();
      $user_id = auth()->user()->id;
      $Geb = new Geb;
      $Geb->user_id = $user->id;
      $Geb->kwh = $request->kwh;
      $Geb->kwm_deviation = $request->kwm_deviation;
      $Geb->kvarh = $request->kvarh;
      $Geb->kvarsh_deviation = $request->kvarsh_deviation;
      $Geb->kevah = $request->kevah;
      $Geb->kevah_deviation = $request->kevah_deviation;
      $Geb->pf = $request->pf;
      $Geb->pf_deviation = $request->pf_deviation;
      $Geb->md = $request->md;
      $Geb->md_deviation = $request->md_deviation;
      $Geb->turbine = $request->turbine;
      $Geb->turbine_deviation = $request->turbine_deviation;
      $Geb->mf = $request->mf;
      $Geb->save();

      return response()->json([
        "message" => "Geb Record created"
      ], 200);
    }
    public function GetGebListing()
    {
      $id =  auth()->user()->id;
      $Geb = Geb::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);

      if ($Geb) {
        return response($Geb, 200);
      } else if(!$Geb){
        return response()->json([
          "message" => "Geb Record not found"
        ], 404);
      }
    }
    public function GebUpdated(Request $request ,$id)
    {
        $Geb = Geb::find($request->id);
        $Geb -> kwh = $request -> kwh;
        $Geb -> kwm_deviation = $request -> kwm_deviation;
        $Geb->  kvarh = $request-> kvarh;
        $Geb -> kvarsh_deviation = $request -> kvarsh_deviation;
        $Geb -> kevah = $request -> kevah;
        $Geb -> kevah_deviation = $request -> kevah_deviation;
        $Geb -> pf = $request -> pf;
        $Geb -> pf_deviation = $request -> pf_deviation;  
        $Geb -> md = $request -> md;  
        $Geb -> md_deviation = $request -> md_deviation;  
        $Geb -> turbine = $request -> turbine;  
        $Geb -> turbine_deviation = $request -> turbine_deviation;  
        $Geb->mf = $request->mf;
        $result = $Geb -> save();
        if($result){
            return["Result"=>"Geb Has been Update"];
        }
        else{
            return["Result"=>"Update operation has been failed"];
        }

    } 
    public function DeleteGeb($id)
    {
      if(Geb::where('id', $id)->exists()) {
        $Geb = Geb::find($id);
        $Geb->delete();

        return response()->json([
          "message" => "Geb records deleted"
        ], 200);
      } else {
        return response()->json([
          "message" => "Geb not found"
        ], 404);
      }
    }

    // GEB REPORT ADD 
    public function UploadReportGebSharch($date)
     {  
        $id =  auth()->user()->id;
        $GebReportUpload = GebReportUpload::where('date',$date)
        ->where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($GebReportUpload, 200);
     }
    public function UploadReportGebAdd(Request $request)
    {
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $GebReportUpload = new GebReportUpload;
        $GebReportUpload ->user_id = $user->id;
        $GebReportUpload-> date = $request->date;
        $GebReportUpload-> kwh = $request ->kwh;
        $GebReportUpload-> kvarh = $request ->kvarh;
        $GebReportUpload-> kevah = $request ->kevah;
        $GebReportUpload-> md = $request ->md;
        $GebReportUpload-> turbine = $request ->turbine;
        $GebReportUpload-> save();

        return response()->json([
            "message" => "Report Upload successfully"
        ], 200);
    }
    public function UploadReportGebUpdate(Request $request)
    {
        $GebReportUpload = GebReportUpload::find($request->id);
        $GebReportUpload-> kwh = $request ->kwh;
        $GebReportUpload-> kvarh = $request ->kvarh;
        $GebReportUpload-> kevah = $request ->kevah;
        $GebReportUpload-> md = $request ->md;
        $GebReportUpload-> turbine = $request ->turbine;

        $result = $GebReportUpload ->save();
        if($result){
            return["Result"=>"Report Update successfully"];
        }
        else{
            return["Result"=>"Update operation has been failed"];
        }
    }
      //GEB VIEW REPORT
     public function ViewReportGebDateSearch($date)
     {
        $user_id =  auth()->user()->id;
       $ViewGEBReportUtility = DB::select("SELECT
       ifnull((j.kwh - j.kwh1),0) kwh,
       ifnull((j.kvarh - j.kvarh1),0) kvarh,
       ifnull((j.kevah - j.kevah1),0) kevah,
       ifnull((j.md),1) md,
       ifnull((j.turbine - j.turbine1),0) turbine,
 
       ifnull((j.kwh - j.kwh1),1) / (j.kevah - j.kevah1)  pf,
       ifnull((j.kwh - j.kwh1),1) / (j.kevah - j.kevah1) *100 -100 pfper,
       
   
       -- round((((j.kwh - j.kwh1) * (select c.mf from tbl_geb c where c.user_id=j.CategoryId) / (j.kwh - j.kwh1)) ) ) as kwhTotal,
       round((((j.kwh - j.kwh1) * (select c.mf from tbl_geb c where c.user_id=j.CategoryId) ) ) ) as kwhtotal,
       round((((j.md) * (select c.mf from tbl_geb c where c.user_id=j.CategoryId) ) ) ) / (j.turbine1) *100 -100 as mdper,
       round((((j.turbine - j.turbine1)) ) ) / (select c.turbine from tbl_geb c where c.user_id=j.CategoryId) *100 -100 as turbineper,
       round((((j.kevah - j.kevah1)) ) ) / (select c.kevah from tbl_geb c where c.user_id=j.CategoryId) *100 -100 as kvahper,
       round((((j.kvarh - j.kvarh1)) ) ) / (select c.kvarh from tbl_geb c where c.user_id=j.CategoryId) *100 -100 as kvarhper,
       (select c.kwm_deviation from tbl_geb c where c.user_id=j.CategoryId) as kwm_deviation,
       (select c.kvarsh_deviation from tbl_geb c where c.user_id=j.CategoryId) as kvarsh_deviation,
       (select c.kevah_deviation	 from tbl_geb c where c.user_id=j.CategoryId) as kevah_deviation,
       (select c.pf_deviation	 from tbl_geb c where c.user_id=j.CategoryId) as pf_deviation,
       (select c.md_deviation	 from tbl_geb c where c.user_id=j.CategoryId) as md_deviation,
       (select c.turbine_deviation	 from tbl_geb c where c.user_id=j.CategoryId) as turbine_deviation,
       round((((j.md)  ) ) )  * (select c.mf from tbl_geb c where c.user_id=j.CategoryId)   as mdTotal,
       -- round((((j.md) * (select c.mf from tbl_geb c where c.user_id=j.CategoryId) ) ) ) as md ,
         round((((j.kwh - j.kwh1) * (select c.mf from tbl_geb c where c.user_id=j.CategoryId) ) ) ) / (select c.kwh from tbl_geb c where c.user_id=j.CategoryId) *100 -100 as kwhtotalper
         
 
       from (
         SELECT 
         u.id as TrId, u.date as TrDate, u.user_id as CategoryId, u.kwh as kwh, u.kvarh,u.kevah as kevah,u.md,u.turbine,
         ifnull((select us.kwh from tbl_geb_report_upload us where us.date < u.date and us.user_id=u.user_id order by id desc limit 1),0) as kwh1,
         ifnull((select us.kvarh from tbl_geb_report_upload us where us.date < u.date and us.user_id=u.user_id order by id desc limit 1),0) as kvarh1,
         ifnull((select us.kevah from tbl_geb_report_upload us where us.date < u.date and us.user_id=u.user_id order by id desc limit 1),0) as kevah1,
         ifnull((select us.turbine from tbl_geb_report_upload us where us.date < u.date and us.user_id=u.user_id order by id desc limit 1),0) as turbine1
         From tbl_geb_report_upload u 
          
         where u.date=?  and u.user_id = $user_id  
       ) as j",[$date]);
     
       
       return response($ViewGEBReportUtility,200);
     }

    //  THERMOPACK ADD EDIT UPDATE 
    public function ThermoopackAdd(Request $request)
    {
      $user = auth()->user();
      $user_id = auth()->user()->id;
      $Thermpack = new Thermpack;
      $Thermpack->user_id = $user->id;
      $Thermpack->coal_1 = $request->coal_1;
      $Thermpack->coal_deviation1    = $request->coal_deviation1;
      $Thermpack->rate_of_cloal1     = $request->rate_of_cloal1;
      $Thermpack->coal_2     = $request->coal_2;
      $Thermpack->coal_deviation2    = $request->coal_deviation2;
      $Thermpack->rate_of_coal2  = $request->rate_of_coal2;
      $Thermpack->delta_t    = $request->delta_t;
      $Thermpack->delta_t_percentage     = $request->delta_t_percentage;
      $Thermpack->chamber_cost   = $request->chamber_cost;
      $Thermpack->chamber_cost_percentage        = $request->chamber_cost_percentage;
      $Thermpack->save();

      return response()->json([
        "message" => "Thermpack record created"
      ], 200);
    }
    public function ThermopackListing()
    {
      $id =  auth()->user()->id;
      $Thermpack = Thermpack::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);

      if($Thermpack){
        return response($Thermpack, 200);
      } else if(!$Thermpack){
        return response()->json([
          "message" => "Thermpack not found"
        ], 404);
        
      }
      // return response($SteamBoiler, 200);
    }  
    public function ThermoopackUpdated(Request $request ,$id)
    {
      $Thermpack = Thermpack::find($request->id);
      $Thermpack->coal_1 = $request->coal_1;
      $Thermpack->coal_deviation1    = $request->coal_deviation1;
      $Thermpack->rate_of_cloal1     = $request->rate_of_cloal1;
      $Thermpack->coal_2     = $request->coal_2;
      $Thermpack->coal_deviation2    = $request->coal_deviation2;
      $Thermpack->rate_of_coal2  = $request->rate_of_coal2;
      $Thermpack->delta_t    = $request->delta_t;
      $Thermpack->delta_t_percentage     = $request->delta_t_percentage;
      $Thermpack->chamber_cost   = $request->chamber_cost;
      $Thermpack->chamber_cost_percentage        = $request->chamber_cost_percentage;
      $result = $Thermpack -> save();
      if($result){
          return["Result"=>"Thermpack Has been Update"];
      }
      else{
          return["Result"=>"Update operation has been failed"];
      }
    }

    public function DeletedThermopack($id)
    {
      if(Thermpack::where('id', $id)->exists()) {
        $Thermpack = Thermpack::find($id);
        $Thermpack->delete();

        return response()->json([
          "message" => "Thermpack records deleted"
        ], 200);
      } else {
        return response()->json([
          "message" => "Thermpack not found"
        ], 404);
      }
    }
    // Thermopack Report Upload
    public function GetThermopackReportUploadDate($date)
    {
      $id =  auth()->user()->id;
      $ThermopackReportUpload = ThermopackReportUpload::where('date', $date)
      ->where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
      return response($ThermopackReportUpload, 200);
       
    }
    public function GetThermopackReportUploadAdd(Request $request)
    {
      $user = auth()->user();
      $user_id = auth()->user()->id;
      $ThermopackReportUpload = new ThermopackReportUpload;
      $ThermopackReportUpload->user_id =$user->id;
      $ThermopackReportUpload->date = $request->date;
      $ThermopackReportUpload->chamber   = $request->chamber;
      $ThermopackReportUpload->coal_1 = $request->coal_1;
      $ThermopackReportUpload->coal_2 = $request->coal_2;
      $ThermopackReportUpload->in_temperature = $request->in_temperature;
      $ThermopackReportUpload->out_temperature = $request->out_temperature;
      $ThermopackReportUpload->pump_presure = $request->pump_presure;
      $ThermopackReportUpload->circuit_presure = $request->circuit_presure;
      $ThermopackReportUpload->save();

      return response()->json([
        "message" => "Thermopack Report Upload  record created"
      ], 200);

    }
    public function GetThermopackReportUploadUpdated(Request $request,$id)
    {
      $ThermopackReportUpload = ThermopackReportUpload::find($request->id);
      $ThermopackReportUpload->chamber   = $request->chamber;
      $ThermopackReportUpload->coal_1 = $request->coal_1;
      $ThermopackReportUpload->coal_2 = $request->coal_2;
      $ThermopackReportUpload->in_temperature = $request->in_temperature;
      $ThermopackReportUpload->out_temperature = $request->out_temperature;
      $ThermopackReportUpload->pump_presure = $request->pump_presure;
      $ThermopackReportUpload->circuit_presure = $request->circuit_presure;
      $result = $ThermopackReportUpload ->save();
      if($result){
          return["Result"=>"Thermopack  Report Upload Has been Update"];
      }
      else{
          return["Result"=>"Update operation has been failed"];
      }

    }
    // REPORT THEMOPACK VIEW DATE
    public function ViewReportThermopackDateSearchNew($date)
    {
     $user_id =  auth()->user()->id;
     $ViewReportTehrmopackQuality = DB::select("SELECT
    
    ifnull((j.chamber),1) chamber,
    ifnull((j.pump_presure),1) pump_presure,
    ifnull((j.in_temperature),1) in_temperature,
    ifnull((j.coal_1),1) as col1,
    ifnull((j.coal_2),1) as col2,
    ifnull((j.circuit_presure),1) as circuit_presure,

    round((((j.in_temperature) - (j.out_temperature)))) as dt,
    round((((j.in_temperature) - (j.out_temperature)))) / (select c.delta_t from tbl_thermopack c where c.user_id=j.CategoryId) *100 -100 as dtper,
    
    round((((j.coal_1) ) ) ) / (select c.coal_1 from tbl_thermopack c where c.user_id=j.CategoryId) *100 -100 as coal_1,
    round((((j.coal_2) ) ) ) / (select c.coal_2  from tbl_thermopack c where c.user_id=j.CategoryId) *100 -100 as coal_2,
    (select c.coal_deviation1 from tbl_thermopack c where c.user_id=j.CategoryId) as coal_deviation1,
    (select c.coal_deviation2 from tbl_thermopack c where c.user_id=j.CategoryId) as coal_deviation2,
    (select c.delta_t from tbl_thermopack c where c.user_id=j.CategoryId) as delta_t,
    (select c.chamber_cost from tbl_thermopack c where c.user_id=j.CategoryId) as chamber_cost,
    (select c.chamber_cost_percentage from tbl_thermopack c where c.user_id=j.CategoryId) as chamber_cost_percentage,


     round(((((j.coal_1) * (select c.rate_of_cloal1 from tbl_thermopack c where c.user_id=j.CategoryId) ) ) ) + (j.coal_2) * (select c.rate_of_coal2 from tbl_thermopack c where c.user_id=j.CategoryId)) / (j.chamber) as cc,
     round((((((j.coal_1) * (select c.rate_of_cloal1 from tbl_thermopack c where c.user_id=j.CategoryId) ) ) ) + (j.coal_2) * (select c.rate_of_coal2 from tbl_thermopack c where c.user_id=j.CategoryId)) / (j.chamber)) / ((select c.chamber_cost  from tbl_thermopack c where c.user_id=j.CategoryId)) *100 -100 as ccper
     -- round((((j.coal_2) * (select c.rate_of_coal2 from tbl_thermopack c where c.user_id=j.CategoryId) ) ) ) as coal_2total
     -- round((((j.coal_1) * (select c.rate_of_cloal1 from tbl_thermopack c where c.user_id=j.CategoryId) ) ) ) as coal_1total,
     -- round((((j.coal_2) * (select c.rate_of_coal2 from tbl_thermopack c where c.user_id=j.CategoryId) ) ) ) as coal_2total,

     from (
       SELECT 
      u.id as TrId,u.user_id as userid, u.date as TrDate, u.user_id  as CategoryId, u.chamber as chamber,u.pump_presure as pump_presure, u.coal_1 as coal_1,u.coal_2 as coal_2,u.in_temperature as in_temperature,u.out_temperature as out_temperature,u.circuit_presure as circuit_presure,
       ifnull((select us.chamber from tbl_thermopack_report_upload us where us.date < u.date and us.user_id=u.user_id order by id desc limit 1),0) as chamberTwo,
       ifnull((select us.pump_presure from tbl_thermopack_report_upload us where us.date < u.date and us.user_id=u.user_id order by id desc limit 1),0) as pump_presureTwo,
       ifnull((select us.coal_1 from tbl_thermopack_report_upload us where us.date < u.date and us.user_id=u.user_id order by id desc limit 1),0) as coal_1Two,
       ifnull((select us.coal_2 from tbl_thermopack_report_upload us where us.date < u.date and us.user_id=u.user_id order by id desc limit 1),0) as coal_2Two,
       ifnull((select us.in_temperature from tbl_thermopack_report_upload us where us.date < u.date and us.user_id=u.user_id order by id desc limit 1),0) as in_temperatureTwo,
       ifnull((select us.out_temperature from tbl_thermopack_report_upload us where us.date < u.date and us.user_id=u.user_id order by id desc limit 1),0) as out_temperatureTwo,
       ifnull((select us.circuit_presure   from tbl_thermopack_report_upload us where us.date < u.date and us.user_id=u.user_id order by id desc limit 1),0) as circuit_presureTwo
        
       From tbl_thermopack_report_upload u
       
       where u.date=?  and u.user_id = $user_id  
     ) as j",[$date]);
  
     return response($ViewReportTehrmopackQuality, 200);
   }
    // STEAM BOLIER ADD EDIT UPDATE 
    public function SteamBolierAdd(Request $request)
    {
      $user = auth()->user();
      $user_id = auth()->user()->id;
      $SteamBoiler = new SteamBoiler;
      $SteamBoiler->user_id =$user->id;
      $SteamBoiler->bfw = $request->bfw;
      $SteamBoiler->temperature  = $request->temperature;
      $SteamBoiler->bfw_percentage       = $request->bfw_percentage;
      $SteamBoiler->bfw_temperature_percentage   = $request->bfw_temperature_percentage;
      $SteamBoiler->coal_1       = $request->coal_1;
      $SteamBoiler->coal_2   = $request->coal_2;
      $SteamBoiler->coal_deviation_1 = $request->coal_deviation_1;
      $SteamBoiler->coal_deviation_2     = $request->coal_deviation_2;
      $SteamBoiler->rate_of_coal_1       = $request->rate_of_coal_1;
      $SteamBoiler->rate_of_coal_2       = $request->rate_of_coal_2;
      $SteamBoiler->steam_cost  = $request->steam_cost;
      $SteamBoiler->steam_cost_percentage  = $request->steam_cost_percentage;
      $SteamBoiler->save();

      return response()->json([
        "message" => "SteamBoiler record created"
      ], 200);
    }
    public function SteamBolierUpadated(Request $request, $id)
    {
      $SteamBoiler = SteamBoiler::find($request->id);
      $SteamBoiler->bfw = $request->bfw;
      $SteamBoiler->temperature  = $request->temperature;
      $SteamBoiler->bfw_percentage       = $request->bfw_percentage;
      $SteamBoiler->bfw_temperature_percentage   = $request->bfw_temperature_percentage;
      $SteamBoiler->coal_1       = $request->coal_1;
      $SteamBoiler->coal_2   = $request->coal_2;
      $SteamBoiler->coal_deviation_1 = $request->coal_deviation_1;
      $SteamBoiler->coal_deviation_2     = $request->coal_deviation_2;
      $SteamBoiler->rate_of_coal_1       = $request->rate_of_coal_1;
      $SteamBoiler->rate_of_coal_2       = $request->rate_of_coal_2;
      $SteamBoiler->steam_cost  = $request->steam_cost;
      $SteamBoiler->steam_cost_percentage  = $request->steam_cost_percentage;
      $result = $SteamBoiler ->save();
      if($result){
          return["Result"=>"SteamBoiler Has been Update"];
      }
      else{
          return["Result"=>"Update operation has been failed"];
      }

    }
    public function DeletedSteamBolier($id)
    {
      if(SteamBoiler::where('id', $id)->exists()) {
        $SteamBoiler = SteamBoiler::find($id);
        $SteamBoiler->delete();

        return response()->json([
          "message" => "SteamBoiler records deleted"
        ], 200);
      } else {
        return response()->json([
          "message" => "SteamBoiler not found"
        ], 404);
      }
      
    }
    public function SteamBolierListing()
    {
      $id =  auth()->user()->id;
      $SteamBoiler = SteamBoiler::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);

      if($SteamBoiler){
        return response($SteamBoiler, 200);
      } else if(!$SteamBoiler){
        return response()->json([
          "message" => "SteamBoiler not found"
        ], 404);
        
      }
      
      // return response($SteamBoiler, 200);
    }     
    // STEAM BOLIER REPORT ADD
    public function SteamBoliersDataAdd(Request $request)
    {

     $user = auth()->user();
     $user_id = auth()->user()->id;
     $SteamBolierReportUpload = new SteamBolierReportUpload;
     $SteamBolierReportUpload->user_id =$user->id;
     $SteamBolierReportUpload->date = $request->date;
     $SteamBolierReportUpload->bfw  = $request->bfw;
     $SteamBolierReportUpload->coal_1 = $request->coal_1;
     $SteamBolierReportUpload->coal_2 = $request->coal_2;
     $SteamBolierReportUpload->bfw_temperature = $request->bfw_temperature;
     $SteamBolierReportUpload->save();

     return response()->json([
       "message" => "Steam Bolier Report Upload  record created"
     ], 200);


    }
    public function GetSteamBoliersDataQuery($date)
    {
       $id =  auth()->user()->id;
       $SteamBolierReportUpload = SteamBolierReportUpload::where('date', $date)
       ->where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
       return response($SteamBolierReportUpload, 200);
      
    }
    public function GetSteamBoliersDataQueryUpdated(Request $request,$id)
    {
     $SteamBolierReportUpload = SteamBolierReportUpload::find($request->id);
     $SteamBolierReportUpload->bfw  = $request->bfw;
     $SteamBolierReportUpload->coal_1 = $request->coal_1;
     $SteamBolierReportUpload->coal_2 = $request->coal_2;
     $SteamBolierReportUpload->bfw_temperature = $request->bfw_temperature;
     $result = $SteamBolierReportUpload ->save();
     if($result){
         return["Result"=>"SteamBolier  Report Upload Has been Update"];
     }
     else{
         return["Result"=>"Update operation has been failed"];
     }

    }
    // REPORT VIEW STEAM BOLIER 
    public function ViewReportSteamBoilerDateSearchNew($date)
    {
      $user_id =  auth()->user()->id;
      $ViewReportTehrmopackQuality = DB::select("SELECT
     
      ifnull((j.bfw),1) bfw,
      ifnull((j.bfw_temperature),1) bfw_temperature,
      ifnull((j.coal_1),1) coal_1,
      ifnull((j.coal_2),1) coal_2,
   
 
         
      
      round((((j.bfw) ) ) ) / (select c.bfw from tbl_steam_boiler c where c.user_id=j.CategoryId) *100 -100 as bfwper,
      round((((j.bfw_temperature) ) ) ) / (select c.temperature from tbl_steam_boiler c where c.user_id=j.CategoryId) *100 -100 as tempper,
      round(((((j.coal_1) * (select c.rate_of_coal_1 from tbl_steam_boiler c where c.user_id=j.CategoryId) ) ) ) +   (j.coal_2) * (select c.rate_of_coal_2 from tbl_steam_boiler c where c.user_id=j.CategoryId))  / (j.bfw) as sc,
      round(((((j.coal_1) * (select c.rate_of_coal_1 from tbl_steam_boiler c where c.user_id=j.CategoryId) ) ) ) +   (j.coal_2) * (select c.rate_of_coal_2 from tbl_steam_boiler c where c.user_id=j.CategoryId))  / (j.bfw)  / (select c.steam_cost from tbl_steam_boiler c where c.user_id=j.CategoryId) *100 -100 scper,
      round(((j.coal_1) ) )  / 100 -100 as coal_1per,
      round(((j.coal_2) ) )  / 100 -100 as coal_2per,
      (select c.bfw_percentage  from tbl_steam_boiler c where c.user_id=j.CategoryId) as bfw_percentageold,
      (select c.bfw_temperature_percentage  from tbl_steam_boiler c where c.user_id=j.CategoryId) as bfw_temperature_percentageold,
      (select c.coal_deviation_1  from tbl_steam_boiler c where c.user_id=j.CategoryId) as coal_deviation_1,
      (select c.coal_deviation_2  from tbl_steam_boiler c where c.user_id=j.CategoryId) as coal_deviation_2,
      (select c.steam_cost_percentage  from tbl_steam_boiler c where c.user_id=j.CategoryId) as steam_cost_percentage

      
 
       from (
         SELECT 
         u.id as TrId,u.user_id as userid , u.date as TrDate, u.user_id  as CategoryId, u.bfw as bfw,u.bfw_temperature as bfw_temperature,u.coal_1 as coal_1,u.coal_2 as coal_2,
         ifnull((select us.bfw from tbl_steam_boiler_report_upload us where us.date < u.date and us.steambolier_id=u.steambolier_id order by id desc limit 1),0) as bfwTwo
        
          
         From tbl_steam_boiler_report_upload u
          
         where u.date=?  and u.user_id = $user_id  
       ) as j",[$date]);
    
    
       return response($ViewReportTehrmopackQuality, 200);
    }
    // LOGOUT 
    // WATER QUALITY MODULE
    public function GetWaterQualityLisiting()
     {  
         $id =  auth()->user()->id;
         $WaterQuilty = WaterQuilty::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
         return response($WaterQuilty, 200);
     }
     public function WaterQualityAdd(Request $request)
     {  
       $user = auth()->user();
       $user_id = auth()->user()->id;
       $WaterQuilty = new WaterQuilty;
       $WaterQuilty->user_id =$user->id;
       $WaterQuilty->machine_name = $request->machine_name;
       $WaterQuilty->tds = $request->tds;
       $WaterQuilty->tds_percentage = $request->tds_percentage;
       $WaterQuilty->ph = $request->ph;
       $WaterQuilty->ph_deviation = $request->ph_deviation;
       $WaterQuilty->hardness = $request->hardness;
       $WaterQuilty->hardness_percentage = $request->hardness_percentage;
       $WaterQuilty->save();
 
       return response()->json([
         "message" => "Water Quilty  record created"
       ], 200);
 
     }
     public function WaterQualityUpdate(Request $request)
     {
         $WaterQuilty = WaterQuilty::find($request->id);
         $WaterQuilty->machine_name = $request->machine_name;
         $WaterQuilty->tds = $request->tds;
         $WaterQuilty->tds_percentage = $request->tds_percentage;
         $WaterQuilty->ph = $request->ph;
         $WaterQuilty->ph_deviation = $request->ph_deviation;
         $WaterQuilty->hardness = $request->hardness;
         $WaterQuilty->hardness_percentage = $request->hardness_percentage;
         $result = $WaterQuilty -> save();
         if($result){
             return["Result"=>"WaterQuilty HAs Been Update"];
         }
         else{
             return["Result"=>"Update operation has been failed"];
         }
     }
     public function WaterQualityDelete($id)
     {
         if(WaterQuilty::where('id', $id)->exists()){
             $WaterQuilty = WaterQuilty::find($id);  
             $WaterQuilty->delete();
 
             return response()->json([
                 "message" => "WaterQuilty records deleted"
             ], 200);
         } else {
             return response()->json([
                 "message" => "WaterQuilty Not found"
             ], 404);
         }
     }
      // GetWaterQualityReportUploadAdd
    public function GetWaterQualityReportUploadAdd(Request $request)
    {
      $machine_name_id = WaterQuilty::select('machine_name')->get();
      $user = auth()->user();
      $user_id = auth()->user()->id;
      $WaterQualityReportUploard = new WaterQualityReportUploard;
      $WaterQualityReportUploard->user_id =$user->id;
      $WaterQualityReportUploard->machine_name_id = $request->machine_name_id;
      $WaterQualityReportUploard->date = $request->date;
      $WaterQualityReportUploard->tds    = $request->tds;
      $WaterQualityReportUploard->ph = $request->ph;
      $WaterQualityReportUploard->hardness = $request->hardness;
      $WaterQualityReportUploard->save();
  
      return response()->json([
        "message" => "WaterQuality Report Upload  record created"
      ], 200);
      
    }
    public function GetWaterQualityReportUploadUpdated(Request $request,$id)
    {
      $WaterQualityReportUploard = WaterQualityReportUploard::find($request->id);
      $WaterQualityReportUploard->tds    = $request->tds;
      $WaterQualityReportUploard->ph = $request->ph;
      $WaterQualityReportUploard->hardness = $request->hardness;
      $result = $WaterQualityReportUploard ->save();
      if($result){
          return["Result"=>"WaterQuality   Report Upload Has been Update"];
      }
      else{
          return["Result"=>"Update operation has been failed"];
      }

    }
    public function GetWaterQualityReportDateSearch($date)
    {
      $id =  auth()->user()->id;
      $WaterQuilty = DB::table('tbl_water_quality_report_upload')
      ->join('tbl_water_quality','tbl_water_quality_report_upload.machine_name_id','=','tbl_water_quality.id')
      ->select('tbl_water_quality_report_upload.id','tbl_water_quality.id as machine_name_id','tbl_water_quality.machine_name','tbl_water_quality_report_upload.date','tbl_water_quality_report_upload.tds','tbl_water_quality_report_upload.ph','tbl_water_quality_report_upload.hardness')
      ->where('date', $date)
      ->where('tbl_water_quality_report_upload.user_id','=', $id)
      ->get();
       return response($WaterQuilty, 200);
    }
    // WATER QUALITY 
    public function ViewReportWaterQualityDateSearch($date)
    {
    $id =  auth()->user()->id;
    $ViewReportwaterQuality = \DB::table('tbl_water_quality_report_upload')

      ->select('machine_name_id','tbl_water_quality.machine_name',
        DB::raw('sum(tbl_water_quality_report_upload.tds )  as tdsreport'),
        DB::raw('sum(tbl_water_quality_report_upload.ph )  as phreport'),
        DB::raw('sum(tbl_water_quality_report_upload.hardness )  as hardnessreport'),
        DB::raw('sum(tbl_water_quality_report_upload.tds/tbl_water_quality.tds *100 -100) as tds_per'),
        DB::raw('sum(tbl_water_quality_report_upload.ph/tbl_water_quality.ph *100 -100) as ph_per'),
        DB::raw('sum(tbl_water_quality_report_upload.hardness/tbl_water_quality.hardness *100 -100) as hardness_per'),
        DB::raw('sum(tbl_water_quality.ph_deviation )  as ph_deviation'),
        DB::raw('sum(tbl_water_quality.tds_percentage )  as tds_percentage'),
        DB::raw('sum(tbl_water_quality.hardness_percentage )  as hardness_percentag')
        
        
        )
      ->join('tbl_water_quality','tbl_water_quality_report_upload.machine_name_id','=','tbl_water_quality.id')
      ->where('date',$date)
      ->where('tbl_water_quality_report_upload.user_id','=', $id)
      ->where('tbl_water_quality.user_id','=', $id)
      ->groupBy('machine_name_id','machine_name')
      ->get();
      
      return response($ViewReportwaterQuality, 200);
    
    }
    // SUPPLY PUMP
     public function GetSupplyPumpListing()
     {
       $id =  auth()->user()->id;
       $SupplyPump = SupplyPump::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
       return response($SupplyPump, 200);
     }
     public function GetSupplyPumpDataAdd(Request $request)
     {
       $user = auth()->user();
       $user_id = auth()->user()->id;
       $SupplyPump = new SupplyPump;
       $SupplyPump->user_id =$user->id;
       $SupplyPump->name = $request->name;
       $SupplyPump->average = $request->average;
       $SupplyPump->deviation = $request->deviation;
       $SupplyPump->save();
 
       return response()->json([
         "message" => "SupplyPump  record created"
       ], 200);
 
     }
     public function GetSupplyPumpDataUpdated(Request $request,$id)
     {
      $SupplyPump = SupplyPump::find($request->id);
      $SupplyPump->name = $request->name;
      $SupplyPump->average = $request->average;
      $SupplyPump->deviation = $request->deviation;
    
      $result = $SupplyPump ->save();
      if($result){
          return["Result"=>"SupplyPump Has been Update"];
      }
      else{
          return["Result"=>"Update operation has been failed"];
      }
     }
     public function GetSupplyPumpDataDeleted($id)
     {
      if(SupplyPump::where('id', $id)->exists()) {
        $SupplyPump = SupplyPump::find($id);
        $SupplyPump->delete();

        return response()->json([
          "message" => "SupplyPump records deleted"
        ], 200);
      } else {
        return response()->json([
          "message" => "SupplyPump not found"
        ], 404);
      }

     }
    //  SUPPLYPUMP REPORT ADD
     // SupplyPump Report 

     public function GetSupplyPumpReportUploadListing()
     {
 
        $SupplyPumpReportUploard = DB::table('tbl_supply_pump')
         //  ->select('tbl_supply_pump.name')
         //  ->get();
         ->join('tbl_supply_pump_report_upload', 'tbl_supply_pump.id', '=', 'tbl_supply_pump_report_upload.supplyp_name_id')// joining the contacts table , where user_id and contact_user_id are same
         ->select('tbl_supply_pump.name', 'tbl_supply_pump_report_upload.date','tbl_supply_pump_report_upload.flow','tbl_supply_pump_report_upload.unit')
         ->get();
          return response($SupplyPumpReportUploard, 200);
       
     }
     public function GetSupplyPumpReportUploadAdd(Request $request)
     {
         
       $SupplyPumpDatListing = SupplyPump::select('name')->get();
       $user = auth()->user();
       $user_id = auth()->user()->id;
       $SupplyPumpReportUploard = new SupplyPumpReportUploard;
       $SupplyPumpReportUploard->user_id =$user->id;
       $SupplyPumpReportUploard->supplyp_name_id = $request->supplyp_name_id;
       $SupplyPumpReportUploard->date = $request->date;
       $SupplyPumpReportUploard->flow     = $request->flow;
       $SupplyPumpReportUploard->unit = $request->unit;
       $SupplyPumpReportUploard->save();
   
       return response()->json([
         "message" => "Supply Pump Report Upload  record created"
       ], 200);
 
     }
    
    public function GetSupplyPumpReportUploadDateSerch($date)
     {
        $id =  auth()->user()->id;
        $SupplyPumpDateSeach = DB::table('tbl_supply_pump_report_upload')
         ->join('tbl_supply_pump', 'tbl_supply_pump_report_upload.supplyp_name_id', '=', 'tbl_supply_pump.id')
         ->select('tbl_supply_pump_report_upload.id','tbl_supply_pump.name', 'tbl_supply_pump_report_upload.date','tbl_supply_pump_report_upload.flow','tbl_supply_pump_report_upload.unit')
         ->where('date', $date)
         ->where('tbl_supply_pump_report_upload.user_id','=', $id)
         ->get();
         return response($SupplyPumpDateSeach, 200);
     }
     public function SupplyPumpReportUploadUpdated(Request $request)
     {
         $SupplyPumpReportUpload = SupplyPumpReportUploard::find($request->id);
         $SupplyPumpReportUpload->flow = $request->flow;
         $SupplyPumpReportUpload->unit = $request->unit;
         $result = $SupplyPumpReportUpload->save();
         if($result){
             return["Result"=>"Data Update successfully"];
         } else {
             return["Result"=>"Update operation has been failed"];
         }
 
     }
    // SUPPLEPUMP REPORT VIEW
    public function ViewReportSupplyPumpDateSearch($date)
    {
      $user_id =  auth()->user()->id;
      $ViewReportUtility = DB::select("SELECT
      ifnull((j.flow - j.flow1),0) flow,
      ifnull((j.unit - j.unit1),0) unit,
     
      ifnull(round((j.flow - j.flow1) / (j.unit - j.unit1),2),0) as average,
      
      round((((j.flow - j.flow1) / (j.unit - j.unit1) / (select c.average from tbl_supply_pump c where c.id=j.CategoryId)) * 100) - 100 ,2) as dev,

      (select c.name from tbl_supply_pump c where c.id=j.CategoryId) as CategoryName,
      (select c.deviation from tbl_supply_pump c where c.id=j.CategoryId) as deviation
      
       
      from (
        SELECT 
        u.id as TrId,u.user_id as userid, u.date as TrDate, u.supplyp_name_id as CategoryId, u.flow as flow, u.unit,
        ifnull((select us.flow from tbl_supply_pump_report_upload us where us.date < u.date and us.supplyp_name_id=u.supplyp_name_id order by id desc limit 1),0) as flow1,
        ifnull((select us.unit from tbl_supply_pump_report_upload us where us.date < u.date and us.supplyp_name_id=u.supplyp_name_id order by id desc limit 1),0) as unit1

      
        From tbl_supply_pump_report_upload u 
     
       where u.date=?  and u.user_id = $user_id  
      ) as j",[$date]);
      return response($ViewReportUtility,200);
      
    }

    // MISC ADD EDIT UPDATE 
    public function MiscLisiting()
    {   
        $id =  auth()->user()->id;
        $Misc = Misc::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($Misc, 200);
    }
    public function MiscAdd(Request $request)
    {   
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $Misc = new Misc;
        $Misc->user_id = $user->id;
        $Misc->machine_name = $request->machine_name;
        $Misc->unit = $request->unit;
        $Misc->deviation = $request->deviation;
        $Misc->save();

        return response()->json([
            "message" => " Misc records Add"
        ], 200);
    }
    public function MiscUpdate(Request $request)
    {
        $Misc = Misc::find($request->id);
        $Misc->machine_name = $request->machine_name;
        $Misc->unit = $request->unit;
        $Misc->deviation = $request->deviation;
        $result = $Misc -> save();

        if($result){
            return["Result"=>"Misc Has Been Update"];
        } else{
            return["Result"=>"Update operation has been failed"];
        }
    }
    public function MiscDelete($id)
    {
        if(Misc::where('id', $id)->exists()){
            $Misc = Misc::find($id);
            $Misc->delete();

            return response()->json([
                "message" => "Misc record deleted"
            ], 200);
        } else {
            return response()->json([
                "message" => "Misc Not found"
            ], 404);
        }
    }
    // MSIC REPORT ADD
     //MiscReportUpload.
    public function MiscReportUploadSharch($date)
     {
         $id =  auth()->user()->id;
         $MiscReportUpload = DB::table('tbl_misc_report_upload')
         ->join('tbl_misc', 'tbl_misc_report_upload.machine_id', '=', 'tbl_misc.id')
         ->select('tbl_misc_report_upload.id','tbl_misc.id as machin_id','tbl_misc.machine_name','tbl_misc_report_upload.date','tbl_misc_report_upload.unit')
         ->where('date',$date)
         ->where('tbl_misc_report_upload.user_id','=', $id)
         ->get();
         return response($MiscReportUpload ,200);
     }
     //use only sachin this Api
     public function MiscReportUploadSharchh($date,$machine_id)
     {
         if (MiscReportUpload::where('machine_id', $machine_id)->exists()) {
             $MiscReportUploadSharchh = MiscReportUpload::where('date', $date)
             ->where('machine_id', $machine_id)
             ->get()->toJson(JSON_PRETTY_PRINT);
             return response($MiscReportUploadSharchh, 200);
           } else {
             return response()->json([
               "message" => "Utility Categories not found"
             ], 404);
           }
     }
     public function MiscReportUploadAdd(Request $request)
     {   
         $user = auth()->user();
         $user_id = auth()->user()->id;
         $MiscReportUpload = new MiscReportUpload;
         $MiscReportUpload->user_id = $user->id;
         $MiscReportUpload->date = $request->date;
         $MiscReportUpload->machine_id = $request->machine_id;
         $MiscReportUpload->unit = $request->unit;
         $MiscReportUpload-> save();
 
         return response()->json([
             "message" => "Today Record created"
         ], 200);
 
     }
     public function MiscReportUploadUpdate(Request $request)
     {
         $MiscReportUpload = MiscReportUpload::find($request->id);
         $MiscReportUpload->unit = $request->unit;
         $result = $MiscReportUpload->save();
         if($result){
             return["Result"=>"Data Update successfully"];
         } else {
             return["Result"=>"Update operation has been failed"];
         }
 
     }
       //  MISC REPORT VIEW DATE
    public function ViewReportMiscDateSearch($date)
    {
      $user_id =  auth()->user()->id;
      $ViewReportMISC = DB::select("SELECT
      ifnull((j.unitTableReport - j.unitTableReport1),0) unitTableReport,
      
      round((((j.unitTableReport - j.unitTableReport1) / (select c.unit from tbl_misc c where c.id=j.CategoryId)) * 100) - 100 ,2) as dev,
        round((((j.unitTableReport - j.unitTableReport1) ))) as unit,
      

      (select c.machine_name from tbl_misc c where c.id=j.CategoryId) as CategoryName,
      (select c.unit from tbl_misc c where c.id=j.CategoryId) as UnitMachine,
      (select c.deviation	 from tbl_misc c where c.id=j.CategoryId) as deviation
    
      from (
        SELECT 
        u.id as TrId, u.user_id as userid ,u.date as TrDate, u.machine_id  as CategoryId, u.unit as unitTableReport, 
        ifnull((select us.unit from tbl_misc_report_upload us where us.date < u.date and us.machine_id=u.machine_id order by id desc limit 1),0) as unitTableReport1
     
        
        From tbl_misc_report_upload u   
         where u.date=?  and u.user_id = $user_id  
         
      ) as j",[$date]);
      return response($ViewReportMISC, 200);
    }

    //Mano meter Thermopack add update delete
    public function ManoMeterThermopackLisiting()
    {   
        $id =  auth()->user()->id;
        $ManoMeterThermopack = ManoMeterThermopack::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($ManoMeterThermopack, 200);
    }
    public function ManoMeterThermopackAdd(Request $request)
    {   
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $ManoMeterThermopack = new ManoMeterThermopack;
        $ManoMeterThermopack->user_id = $user->id;
        $ManoMeterThermopack->thermopack = $request->thermopack;
        $ManoMeterThermopack->save();

        return response()->json([
            "message" => " Machine Add"
        ], 200);
    }
    public function ManoMeterThermopackUpdate(Request $request)
    {
        $ManoMeterThermopack = ManoMeterThermopack::find($request->id);
        $ManoMeterThermopack->thermopack = $request->thermopack;
        $result = $ManoMeterThermopack -> save();

        if($result){
            return["Result"=>"Machine Has Been Update"];
        } else{
            return["Result"=>"Update operation has been failed"];
        }
    }
    public function ManoMeterThermopackDelete($id)
    {
        if(ManoMeterThermopack::where('id', $id)->exists()){
            $ManoMeterThermopack = ManoMeterThermopack::find($id);
            $ManoMeterThermopack->delete();

            return response()->json([
                "message" => "Machine record deleted"
            ], 200);
        } else {
            return response()->json([
                "message" => "Machine Not found"
            ], 404);
        }
    }
    //ManoMeterThermopackReportUpload.
    public function ManoMeterThermopackReportUploadSharch($date)
    {
        $id =  auth()->user()->id;
        $ManoMeterThermopackReportUpload = DB::table('tbl_mano_meter_thermopack_report_upload')
        ->join('tbl_mano_meter_thermopack','tbl_mano_meter_thermopack_report_upload.machine_id', '=', 'tbl_mano_meter_thermopack.id')
        ->select('tbl_mano_meter_thermopack_report_upload.id','tbl_mano_meter_thermopack.id as machine_id','tbl_mano_meter_thermopack.thermopack','tbl_mano_meter_thermopack_report_upload.date','tbl_mano_meter_thermopack_report_upload.id_fan','tbl_mano_meter_thermopack_report_upload.fd_fan','tbl_mano_meter_thermopack_report_upload.coal_used','tbl_mano_meter_thermopack_report_upload.aph_value','tbl_mano_meter_thermopack_report_upload.aph_temperature','tbl_mano_meter_thermopack_report_upload.value','tbl_mano_meter_thermopack_report_upload.temperature')
        ->where('date',$date)
        ->where('tbl_mano_meter_thermopack_report_upload.user_id','=', $id)
        ->get();
        return response($ManoMeterThermopackReportUpload, 200);
    }
    public function ManoMeterThermopackReportUploadAdd(Request $request)
    {
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $ManoMeterThermopackReportUpload = new ManoMeterThermopackReportUpload;
        $ManoMeterThermopackReportUpload->user_id = $user->id;
        $ManoMeterThermopackReportUpload->date = $request->date;
        $ManoMeterThermopackReportUpload->machine_id = $request->machine_id;    
        $ManoMeterThermopackReportUpload->id_fan = $request->id_fan;
        $ManoMeterThermopackReportUpload->fd_fan = $request->fd_fan;
        $ManoMeterThermopackReportUpload->coal_used = $request->coal_used;
        $ManoMeterThermopackReportUpload->aph_value = $request->aph_value;
        $ManoMeterThermopackReportUpload->aph_temperature = $request->aph_temperature;
        $ManoMeterThermopackReportUpload->value = $request->value;
        $ManoMeterThermopackReportUpload->temperature = $request->temperature;
        $ManoMeterThermopackReportUpload->save();
         return response()->json([
            "message" => "Today Record created"
         ], 200);
    }
    public function ManoMeterThermopackReportUploadUpdate(Request $request)
    {   
        $ManoMeterThermopackReportUpload = ManoMeterThermopackReportUpload::find($request->id);
        $ManoMeterThermopackReportUpload->id_fan = $request->id_fan;
        $ManoMeterThermopackReportUpload->fd_fan = $request->fd_fan;
        $ManoMeterThermopackReportUpload->coal_used = $request->coal_used;
        $ManoMeterThermopackReportUpload->aph_value = $request->aph_value;
        $ManoMeterThermopackReportUpload->aph_temperature = $request->aph_temperature;
        $ManoMeterThermopackReportUpload->value = $request->value;
        $ManoMeterThermopackReportUpload->temperature = $request->temperature;
        $result = $ManoMeterThermopackReportUpload->save();
        if($result){
            return["Result"=>"Data Update successfully"];
        } else {
            return["Result"=>"Update operation has been failed"];
        }

    }
    //  View Report MenoMetor Thermopack
    public function ViewReportMenoMeterDateSearch($date)
    {
      $id =  auth()->user()->id;
      $ViewReportMenometor = \DB::table('tbl_mano_meter_thermopack_report_upload')
      ->join('tbl_mano_meter_thermopack','tbl_mano_meter_thermopack_report_upload.machine_id','=','tbl_mano_meter_thermopack.id')
      ->where('date',$date)
      ->where('tbl_mano_meter_thermopack_report_upload.user_id','=', $id)      
      ->where('tbl_mano_meter_thermopack.user_id','=', $id)      
      ->get();
      return response($ViewReportMenometor, 200);
    }
    //Mano meter Steam Boiller Add update Delete
    public function ManoMeterSteamBoilerLisiting()
    {
        $id =  auth()->user()->id;
        $ManoMeterSteamBoiler = ManoMeterSteamBoiler::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($ManoMeterSteamBoiler, 200);
    }
    public function ManoMeterSteamBoilerAdd(Request $request)
    {   
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $ManoMeterSteamBoiler = new ManoMeterSteamBoiler;
        $ManoMeterSteamBoiler->user_id = $user->id;
        $ManoMeterSteamBoiler->steam_boiler = $request->steam_boiler;
        $ManoMeterSteamBoiler->save();

        return response()->json([
            "message" => "Machine Add"
        ], 200);

    }
    public function ManoMeterSteamBoilerUpdate(Request $request)
    {
        $ManoMeterSteamBoiler = ManoMeterSteamBoiler::find($request->id);
        $ManoMeterSteamBoiler->steam_boiler = $request->steam_boiler;
        $result = $ManoMeterSteamBoiler->save();

        if($result){
            return["Result"=>"Machine Has Been Update"];
        } else{
            return["Result"=>"Machine operation has been failed"];
        }
    }
    public function ManoMeterSteamBoilerDelete($id)
    {
        if(ManoMeterSteamBoiler::where('id', $id)->exists()){
            $ManoMeterSteamBoiler = ManoMeterSteamBoiler::find($id);
            $ManoMeterSteamBoiler->delete();

            return response()->json([
                "message" => "Machine record deleted"
            ], 200);
        } else {
            return response()->json([
                "message" => "Machine Not found"
            ], 404);
        }
    }
    //ManoMeterSteamBoilerReportUpload.
    public function ManoMeterSteamBoilerReportUploadSharch($date)
    {   
        $id =  auth()->user()->id;
        $ManoMeterSteamBoilerReportUpload = DB::table('tbl_mano_meter_steam_boiler_report_upload')
        ->join('tbl_mano_meter_steamboiler','tbl_mano_meter_steam_boiler_report_upload.machine_id', '=', 'tbl_mano_meter_steamboiler.id')
        ->select('tbl_mano_meter_steam_boiler_report_upload.id','tbl_mano_meter_steamboiler.id as machine_id','tbl_mano_meter_steamboiler.steam_boiler','tbl_mano_meter_steam_boiler_report_upload.date','tbl_mano_meter_steam_boiler_report_upload.id_fan','tbl_mano_meter_steam_boiler_report_upload.fd_fan','tbl_mano_meter_steam_boiler_report_upload.coal_used','tbl_mano_meter_steam_boiler_report_upload.aph_value','tbl_mano_meter_steam_boiler_report_upload.aph_temperature','tbl_mano_meter_steam_boiler_report_upload.value','tbl_mano_meter_steam_boiler_report_upload.temperature')
        ->where('date',$date)
        ->where('tbl_mano_meter_steam_boiler_report_upload.user_id','=', $id)
        ->get();
        return response($ManoMeterSteamBoilerReportUpload, 200);
    } 

    public function ManoMeterSteamBoilerReportUploadAdd(Request $request)
    {   
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $ManoMeterSteamBoilerReportUpload = new ManoMeterSteamBoilerReportUpload;
        $ManoMeterSteamBoilerReportUpload->user_id = $user->id;
        $ManoMeterSteamBoilerReportUpload->date = $request->date;
        $ManoMeterSteamBoilerReportUpload->machine_id = $request->machine_id;
        $ManoMeterSteamBoilerReportUpload->id_fan = $request->id_fan;
        $ManoMeterSteamBoilerReportUpload->fd_fan = $request->fd_fan;
        $ManoMeterSteamBoilerReportUpload->coal_used = $request->coal_used;
        $ManoMeterSteamBoilerReportUpload->aph_value = $request->aph_value;
        $ManoMeterSteamBoilerReportUpload->aph_temperature = $request->aph_temperature;
        $ManoMeterSteamBoilerReportUpload->value = $request->value;
        $ManoMeterSteamBoilerReportUpload->temperature = $request->temperature;
        $ManoMeterSteamBoilerReportUpload->save();

        return response()->json([
            "message" => "Today Record created"
        ], 200);
    }
    public function ManoMeterSteamBoilerReportUploadUpdate(Request $request)
    {
        $ManoMeterSteamBoilerReportUpload = ManoMeterSteamBoilerReportUpload::find($request->id);
        $ManoMeterSteamBoilerReportUpload->id_fan = $request->id_fan;
        $ManoMeterSteamBoilerReportUpload->fd_fan = $request->fd_fan;
        $ManoMeterSteamBoilerReportUpload->coal_used = $request->coal_used;
        $ManoMeterSteamBoilerReportUpload->aph_value = $request->aph_value;
        $ManoMeterSteamBoilerReportUpload->aph_temperature = $request->aph_temperature;
        $ManoMeterSteamBoilerReportUpload->value = $request->value;
        $ManoMeterSteamBoilerReportUpload->temperature = $request->temperature;
        $result = $ManoMeterSteamBoilerReportUpload->save();
        if($result){
            return["Result"=>"Data Update successfully"];
        } else {
            return["Result"=>"Update operation has been failed"];
        }
    }
    // VIEW REPORT VIEW
    public function ViewReportMenoMeterSteambolierDateSearch($date)
    { 
      $id =  auth()->user()->id;
      $ViewReportMenometorSteam = \DB::table('tbl_mano_meter_steam_boiler_report_upload')
      ->join('tbl_mano_meter_steamboiler','tbl_mano_meter_steam_boiler_report_upload.machine_id','=','tbl_mano_meter_steamboiler.id')
      ->where('date',$date)
      ->where('tbl_mano_meter_steam_boiler_report_upload.user_id','=', $id)
      ->where('tbl_mano_meter_steamboiler.user_id','=', $id)
      ->get();
      return response($ViewReportMenometorSteam, 200);
    }
    //flue Gas Steam Bolie ADD UPDATE DELETE
    public function GetFlueGasSteamBolierListingData()
     {
      $id =  auth()->user()->id;
      $FlueGasSteamBoliers = FlueGasSteamBoliers::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
      return response($FlueGasSteamBoliers, 200);
     }
     public function GetFlueGasSteamBolierListingDataAdd(Request $request)
     {
      $user = auth()->user();
      $user_id = auth()->user()->id;
      $FlueGasSteamBoliers = new FlueGasSteamBoliers;
      $FlueGasSteamBoliers->user_id =$user->id;
      $FlueGasSteamBoliers->machine_name = $request->machine_name;
      $FlueGasSteamBoliers->value = $request->value;
      $FlueGasSteamBoliers->deviation = $request->deviation;
      $FlueGasSteamBoliers->temperature = $request->temperature;
      $FlueGasSteamBoliers->temperature_deviation = $request->temperature_deviation;
      $FlueGasSteamBoliers->save();

      return response()->json([
        "message" => "Flue Gas SteamBoliers  record created"
      ], 200);
     }
     public function GetFlueGasSteamBolierListingDataUpdated(Request $request,$id)
     {
      $FlueGasSteamBoliers = FlueGasSteamBoliers::find($request->id);
      $FlueGasSteamBoliers->machine_name = $request->machine_name;
      $FlueGasSteamBoliers->value = $request->value;
      $FlueGasSteamBoliers->deviation = $request->deviation;
      $FlueGasSteamBoliers->temperature = $request->temperature;
      $FlueGasSteamBoliers->temperature_deviation = $request->temperature_deviation;
      $result = $FlueGasSteamBoliers ->save();
      if($result){
          return["Result"=>"Flue Gas Steam Boliers Has been Update"];
      }
      else{
          return["Result"=>"Update operation has been failed"];
      }
     } 
     public function GetFlueGasSteamBolierListingDataDelete($id)
     {
      if(FlueGasSteamBoliers::where('id', $id)->exists()) {
        $FlueGasSteamBoliers = FlueGasSteamBoliers::find($id);
        $FlueGasSteamBoliers->delete();

        return response()->json([
          "message" => "FlueGasSteamBoliers records deleted"
        ], 200);
      } else {
        return response()->json([
          "message" => "FlueGasSteamBoliers not found"
        ], 404);
      }
      
     }
    //FlueGasSteamBoilerReportUpload
     public function FlueGasSteamBoilerReportUploadSharch($date)
    {
        $id =  auth()->user()->id;
        $FlueGasSteamBoilerReportUpload = DB::table('tbl_flue_gas_steamboiler_report_upload')
        ->join('tbl_flue_gas_steambolier', 'tbl_flue_gas_steamboiler_report_upload.machine_id', '=', 'tbl_flue_gas_steambolier.id')
        ->select('tbl_flue_gas_steamboiler_report_upload.id','tbl_flue_gas_steambolier.id as machine_id','tbl_flue_gas_steambolier.machine_name','tbl_flue_gas_steamboiler_report_upload.date','tbl_flue_gas_steamboiler_report_upload.value','tbl_flue_gas_steamboiler_report_upload.temperature')
        ->where('date',$date)
        ->where('tbl_flue_gas_steamboiler_report_upload.user_id','=', $id)
        ->get();
        return response($FlueGasSteamBoilerReportUpload ,200);
    }                                                                   
    public function FlueGasSteamBoilerReportUploadAdd(Request $request)
    {
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $FlueGasSteamBoilerReportUpload = new FlueGasSteamBoilerReportUpload;
        $FlueGasSteamBoilerReportUpload->user_id = $user->id;
        $FlueGasSteamBoilerReportUpload->date = $request->date;
        $FlueGasSteamBoilerReportUpload->machine_id = $request->machine_id;
        $FlueGasSteamBoilerReportUpload->value = $request->value;
        $FlueGasSteamBoilerReportUpload->temperature = $request->temperature;
        $FlueGasSteamBoilerReportUpload->save();

        return response()->json([
            "message" => "Today Record created"
        ], 200);

    }
    public function FlueGasSteamBoilerReportUploadUpdate(Request $request)
    {
        $FlueGasSteamBoilerReportUpload = FlueGasSteamBoilerReportUpload::find($request->id);
        $FlueGasSteamBoilerReportUpload->value = $request->value;
        $FlueGasSteamBoilerReportUpload->temperature = $request->temperature;
        $result = $FlueGasSteamBoilerReportUpload->save();
        if($result){
            return["Result"=>"Data Update successfully"];
        } else {
            return["Result"=>"Update operation has been failed"];
        }
    }
    // VIEW REPORT flue GAs STREAM
    public function ViewReportFlueGasSteamBolierDateSearch($date)
      {
        $user_id =  auth()->user()->id;
        $ViewReportFlueGasSteamBolier =  DB::select("SELECT

           ifnull((j.value),1) value,
           ifnull((j.temperature),1) temperature,

           round((((j.value) ) ) ) / (select c.value   from tbl_flue_gas_steambolier c where c.id=j.CategoryId) *100 -100 as value_pr,
           round((((j.temperature) ) ) ) / (select c.temperature   from tbl_flue_gas_steambolier c where c.id=j.CategoryId) *100 -100 as temperature_pr,

           (select c.machine_name from tbl_flue_gas_steambolier c where c.id=j.CategoryId) as CategoryName,
           (select c.deviation from tbl_flue_gas_steambolier c where c.id=j.CategoryId) as deviation,
           (select c.temperature_deviation from tbl_flue_gas_steambolier c where c.id=j.CategoryId) as temperature_deviation
           
      
          from (
            SELECT 
            u.id as TrId,u.user_id as userid, u.date as TrDate, u.machine_id   as CategoryId, u.value as value,u.temperature as temperature,
            ifnull((select us.value from tbl_flue_gas_steamboiler_report_upload us where us.date < u.date and us.machine_id =u.machine_id  order by id desc limit 1),0) as valueTwo,
            ifnull((select us.temperature from tbl_flue_gas_steamboiler_report_upload us where us.date < u.date and us.machine_id =u.machine_id  order by id desc limit 1),0) as temperatureTwo
            From tbl_flue_gas_steamboiler_report_upload u 

            
            where u.date=?  and u.user_id = $user_id  
          ) as j",[$date]);
       
        // where('tbl_flue_gas_thermopack_report_upload.user_id','=', $id);
        return response($ViewReportFlueGasSteamBolier, 200);

      }
    // flue GAs STREAM add update delete
    public function GetFlueGasThermoPackListingData()
     {
      $FlueGasThermoPack = FlueGasThermoPack::get()->toJson(JSON_PRETTY_PRINT);
      return response($FlueGasThermoPack, 200);
     }
     public function GetFlueGasThermoPackListingDataAdd(Request $request)
     {
      $user = auth()->user();
      $user_id = auth()->user()->id;
      $FlueGasThermoPack = new FlueGasThermoPack;
      $FlueGasThermoPack->user_id =$user->id;
      $FlueGasThermoPack->machine_name = $request->machine_name;
      $FlueGasThermoPack->value = $request->value;
      $FlueGasThermoPack->deviation = $request->deviation;
      $FlueGasThermoPack->temperature = $request->temperature;
      $FlueGasThermoPack->temperature_deviation = $request->temperature_deviation;
      $FlueGasThermoPack->save();

      return response()->json([
        "message" => "Flue Gas ThermoPack  record created"
      ], 200);

     }
     public function GetFlueGasThermoPackListingDataUpdated(Request $request,$id)
     {
      $FlueGasThermoPack = FlueGasThermoPack::find($request->id);
      $FlueGasThermoPack->machine_name = $request->machine_name;
      $FlueGasThermoPack->value = $request->value;
      $FlueGasThermoPack->deviation = $request->deviation;
      $FlueGasThermoPack->temperature = $request->temperature;
      $FlueGasThermoPack->temperature_deviation = $request->temperature_deviation;
      $result = $FlueGasThermoPack ->save();
      if($result){
          return["Result"=>"Flue Gas Thermopack Has been Update"];
      }
      else{
          return["Result"=>"Update operation has been failed"];
      }
     }
     public function GetFlueGasThermoPackListingDelete($id)
     {
      if(FlueGasThermoPack::where('id', $id)->exists()) {
        $FlueGasThermoPack = FlueGasThermoPack::find($id);
        $FlueGasThermoPack->delete();

        return response()->json([
          "message" => "FlueGas ThermoPack records deleted"
        ], 200);
      } else {
        return response()->json([
          "message" => "FlueGas ThermoPack not found"
        ], 404);
      }
     }
    //FlueGasThermoPackReportUpload
    public function FlueGasThermoPackReportUploadSearch($date)
    {
        $id =  auth()->user()->id;
        $FlueGasThermoPackReportUpload = DB::table('tbl_flue_gas_thermopack_report_upload')
        ->join('tbl_flue_gas_thermopack','tbl_flue_gas_thermopack_report_upload.machine_id','=','tbl_flue_gas_thermopack.id')
        ->select('tbl_flue_gas_thermopack_report_upload.id','tbl_flue_gas_thermopack.id as machine_id','tbl_flue_gas_thermopack.machine_name','tbl_flue_gas_thermopack_report_upload.date','tbl_flue_gas_thermopack_report_upload.value','tbl_flue_gas_thermopack_report_upload.temperature')
        ->where('date',$date)
        ->where('tbl_flue_gas_thermopack_report_upload.user_id','=', $id)
        ->get();
        return response($FlueGasThermoPackReportUpload,200);
    }
    public function FlueGasThermoPackReportUploadAdd(Request $request)
    {
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $FlueGasThermoPackReportUpload = new FlueGasThermoPackReportUpload;
        $FlueGasThermoPackReportUpload->user_id = $user->id;
        $FlueGasThermoPackReportUpload->date = $request->date;
        $FlueGasThermoPackReportUpload->machine_id = $request->machine_id;
        $FlueGasThermoPackReportUpload->value = $request->value;
        $FlueGasThermoPackReportUpload->temperature =$request->temperature;
        $FlueGasThermoPackReportUpload->save();
        return response()->json([
            "message" => "Today Record created"
        ], 200);
    }
    public function FlueGasThermoPackReportUploadUpdate(Request $request)
    {
        $FlueGasThermoPackReportUpload = FlueGasThermoPackReportUpload::find($request->id);
        $FlueGasThermoPackReportUpload->value = $request->value;
        $FlueGasThermoPackReportUpload->temperature =$request->temperature;
        $result = $FlueGasThermoPackReportUpload->save();
        if($result){
            return["result"=>"Data Update successfully"];
        } else {
            return["result"=>"Update operation has been failed"];
        }

    }
    // VIEW THARMOPAK REPORT
      public function ViewReportFlueGasThermopackDateSearch($date)
      {
        $user_id =  auth()->user()->id;
        $ViewReportFlueGasthermopack =  DB::select("SELECT

           ifnull((j.value),1) value,
           ifnull((j.temperature),1) temperature,

           round((((j.value) ) ) ) / (select c.value   from tbl_flue_gas_thermopack c where c.id=j.CategoryId) *100 -100 as value_pr,
           round((((j.temperature) ) ) ) / (select c.temperature   from tbl_flue_gas_thermopack c where c.id=j.CategoryId) *100 -100 as temperature_pr,

           (select c.machine_name from tbl_flue_gas_thermopack c where c.id=j.CategoryId) as CategoryName,
           (select c.deviation from tbl_flue_gas_thermopack c where c.id=j.CategoryId) as deviation,
           (select c.temperature_deviation from tbl_flue_gas_thermopack c where c.id=j.CategoryId) as temperature_deviation
           
      
          from (
            SELECT 
            u.id as TrId,u.user_id as userid, u.date as TrDate, u.machine_id   as CategoryId, u.value as value,u.temperature as temperature,
            ifnull((select us.value from tbl_flue_gas_thermopack_report_upload us where us.date < u.date and us.machine_id =u.machine_id  order by id desc limit 1),0) as valueTwo,
            ifnull((select us.temperature from tbl_flue_gas_thermopack_report_upload us where us.date < u.date and us.machine_id =u.machine_id  order by id desc limit 1),0) as temperatureTwo
            From tbl_flue_gas_thermopack_report_upload u 

             
            where u.date=?  and u.user_id = $user_id  
          ) as j",[$date]);
       
        // where('tbl_flue_gas_thermopack_report_upload.user_id','=', $id);
        return response($ViewReportFlueGasthermopack, 200);

      }
    // ToDoList
    public function GetToDoListDataListing()
     {
      $id =  auth()->user()->id;
      $ToDoList = ToDoList::where('user_id','=', $id)->get()->toJson(JSON_PRETTY_PRINT);
      return response($ToDoList, 200);
     }
     public function GetToDoListDataAdd(Request $request)
     {
      $user = auth()->user();
      $user_id = auth()->user()->id;
      $ToDoList = new ToDoList;
      $ToDoList->user_id =$user->id;
      $ToDoList->date = $request->date;
      $ToDoList->comment = $request->comment;
      $ToDoList->save();

      return response()->json([
        "message" => "To Do List  record created"
      ], 201);

     }
     public function GetToDoListDataAddUpdated(Request $request,$id)
     {
      $ToDoList = ToDoList::find($request->id);
      $ToDoList->date = $request->date;
      $ToDoList->comment = $request->comment;
      $result = $ToDoList ->save();
      if($result){
          return["Result"=>"ToDoList Has been Update"];
      }
      else{
          return["Result"=>"Update operation has been failed"];
      }

     }
     public function GetToDoListDataDelete($id)
     {
      if(ToDoList::where('id', $id)->exists()) {
        $ToDoList = ToDoList::find($id);
        $ToDoList->delete();

        return response()->json([
          "message" => "ToDoList records deleted"
        ], 202);
      } else {
        return response()->json([
          "message" => "FlueGas ThermoPack not found"
        ], 404);
      }

     }
     // User profile
     public function ProfileUpdate(Request $request,$id)
    {
        $user = auth()->user($request->id);
        $user->firstname = $request->firstname;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->company_name = $request->company_name;
        $user->mobile_code = $request->mobile_code;
        $user->mobile_no = $request->mobile_no;
        $user->address = $request->address;
        $result = $user -> save();

        if($result){
            return["Result"=>"Profile Updated"];
        } else{
            return["Result"=>"Update operation has been failed"];
        }
    }
    public function GetProfileshow()
    {
        $User = auth()->user()->toJson(JSON_PRETTY_PRINT);
        return response($User, 200);
    }

    public function upsertData()
    {      
      $user = auth()->user();
      $user_id = auth()->user()->id;

     $getUserData = DB::table(`tbl_utility_report_upload`)
      ->upsert(collect($new_order)->map(function($item) use($user_id) {
          return [
            'id'=>$item['id'],
            'user_id'=>$user_id,
            'date'=>$item['date'],
            'uitility_categories_id'=>$item['uitility_categories_id'],
            'uitility_subcategories_id'=>$item['uitility_subcategories_id'],
            'em'=>$item['em'],
            'hm'=>$item['hm']];  
      })->toArray(),
       ['id','user_id','uitility_categories_id','uitility_subcategories_id'], ['em' , 'hm']);

       return ($getUserData);
    }

    // public function store(StorePostRequest $request , Post $post ) : PostResource
    //   {
    //     return new PostResource (
    //         $this- > upsert($request , $post )
    //     );
    //   }
    // public function update(UpdatePostRequest $request , Post $post) : PostResource
    // {
    //     return new PostResource (
      
    //         $this- > upsert ($request , $post )
    //     );
    //     }
    // private function upsert (Request $request , Post $post ) : Post
    // {
    // (
    //     return $post
    //         - > setName($request- > name )
    //         - > setDescription($request- > description )
    //         - > commit() ;
    // }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
