<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Admin\Product;
use App\Admin\Category;
use App\Admin\Gallery;
use App\Admin\Setting;
use App\Admin\Blog;
use App\Admin\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Auth;

class AjaxController extends Controller
{

    public function removeImage(Request $request)
    {
        $remove_id = $request->remove_id;
        
		if($request->type == 'category'){
            $category   = Category::findOrFail($remove_id);
            $thumbnail  = $category->getOriginal('thumbnail');
            $category->thumbnail = null;
            $category->save();
            if($thumbnail){
                Storage::delete('/public/category/' . $thumbnail);
                $msg = 'success';
            }
            else{
                $msg = 'failed';
            }
        }
		if($request->type == 'thumbnail'){
            $product    = Product::findOrFail($remove_id);
            $thumbnail  = $product->getOriginal('thumbnail');
            $product->thumbnail = null;
            $product->save();
            if($thumbnail){
                Storage::delete('/public/thumbnail/' . $thumbnail);
                $msg = 'success';
            }
            else{
                $msg = 'failed';
            }
        }
        if($request->type == 'blog'){
            $blog    = Blog::findOrFail($remove_id);
            $thumbnail  = $blog->getOriginal('thumbnail');
            $blog->thumbnail = null;
            $blog->save();
            if($thumbnail){
                Storage::delete('/public/thumbnail/' . $thumbnail);
                $msg = 'success';
            }
            else{
                $msg = 'failed';
            }
        }
        if($request->type == 'gallery'){
            $gallery = Gallery::find($remove_id);
            $gallery_image = $gallery->gallery;
            $gallery->delete();
            
            if($gallery){
                Storage::delete('/public/gallery/' . $gallery_image);
                $msg = 'success';
            }
            else{
                $msg = 'failed';
            }
        }
        if($request->type == 'site_logo'){
            $logo = Setting::where('meta_key','site_logo')->first();
            $site_logo = $logo->meta_value;
            $logo->delete();
            
            if($logo){
                Storage::delete('/public/' . $site_logo);
                $msg = 'success';
            }
            else{
                $msg = 'failed';
            }
        }
       return response()->json(array('msg'=> $msg), 200);
    }
  
	/************************** getTotalCost ***************************/
	public function getTotalCost(Request $request){
		
		$product = Product::find($request->product_id);
		$total_cost[] = $product->price;
		
		/************ Shipping *****************/
		$shipping = $request->shipping;
		//$total_cost[]  = '5';
		//if($shipping=='drop_ship')
		//$total_cost[]  = '10';
		$address_id = 0;
		$saddress = '';
		$from_shipping_id 	= $request->from_shipping;
		$to_shipping_id 	= $request->to_shipping;
		$from_address		= $this->getAddress($from_shipping_id);
		if(!is_null($from_address)){
		$sfaddress = $from_address->first_name.' '.$from_address->last_name.' '.$from_address->company.' '. $from_address->street_address.' '. $from_address->street_address_2.' '.$from_address->CITY.' '.$from_address->STATE_NAME.' '.$from_address->zip_code;
		$from_address_id = $from_address->id;
		}else{
			$sfaddress = '';
			$from_address_id = 0;
		}
		
		$to_address 		= $this->getAddress($to_shipping_id);
		if(!is_null($to_address)){
			$staddress = $to_address->first_name.' '.$to_address->last_name.' '.$to_address->company.' '. $from_address->street_address.' '. $from_address->street_address_2.' '.$to_address->CITY.' '.$to_address->STATE_NAME.' '.$to_address->zip_code;
			$to_address_id = $to_address->id;
		}else{
			$staddress = '';
			$to_address_id = 0;
		}
		/*********** Width and height calculations ******/
		
		if($request->width_f&&$request->height_f){
			$product_cost = ProductAttribute::select('width','height','price')->where(['product_id'=>$request->product_id,'attribute'=>'size'])->first();
			$width_f 		= $request->width_f;
			$width_i 		= $request->width_i?$request->width_i/12:0;
			$height_f 		= $request->height_f;
			$height_i 		= $request->height_i?$request->height_i/12:0;
			$sq_feet 		= ($width_f+$width_i)*($height_f+$height_i);
			$sq_feet 		= sprintf("%01.2f", $sq_feet);
			$area_cost		= $sq_feet*$product_cost->price;
			$total_cost[] 	= $area_cost;
		}
		
		/*********** Attribute **************/
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->fixed_price,'attribute'=>'price_type'])->first()['price'];
		//print_r($request->fixed_price); dd();
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->design_proof,'attribute'=>'design_proof'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->graphic,'attribute'=>'graphic'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->hardware,'attribute'=>'hardware'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->turnaround,'attribute'=>'turnaround'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->finishing,'attribute'=>'finishing'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->no_of_sides,'attribute'=>'no_of_sides'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->material,'attribute'=>'material'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->pole_pocket,'attribute'=>'pole_pocket'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->hem,'attribute'=>'hem'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->grommet,'attribute'=>'grommet'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->windslit,'attribute'=>'windslit'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->webbing,'attribute'=>'webbing'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->corners,'attribute'=>'corners'])->first()['price'];
		$total_cost[] = ProductAttribute::select('price')->where(['id'=>$request->rope,'attribute'=>'rope'])->first()['price'];
		if($product->product_bundle && $request->product_id && $request->qty1 ){
			$bundle =  ProductAttribute::select('value','price')->where(['product_id'=>$request->product_id,'id'=>$request->qty1])->first();
			if($bundle->count()>0){
				$total_cost[] 			= $bundle->price;
				$subtotal 					= array_sum($total_cost);
				$per_porduct_cost 	= $subtotal/$bundle->value;
				$qty 						= $bundle->value;
			}
		}else{
			$per_porduct_cost = array_sum($total_cost);
			if($request->qty){
				$subtotal = $per_porduct_cost*$request->qty;
			}else{
				$subtotal = array_sum($total_cost);
			}
			$qty = $request->qty;
		}
		
		//return $total_cost;
		
		$percentage 	= 3;
		$totalCost 		= $subtotal;
		$shipping_cost  = 0;
		$delivery_time  = 0;
		$dropdown 		= '<option value="0">Free Shipping</option>';
		/* if($shipping == 'default_ship'){
			$shipping_cost 	= number_format(($percentage / 100) * $totalCost,2);
			$dropdown		=  '<option value="'.$shipping_cost.'">$'.$shipping_cost.'</option>';
		} */
		$shipping_type_value = '';
		if($shipping == 'drop_ship'){
			$shipping_drop = $this->fedExRate($from_address,$to_address);
			
			if(!isset($shipping_drop['err'])){
				//$shipping_type_value =  array_keys($shipping_drop)[0];
				
				$dropdown = '';
				//$shipping_cost = array_values($shipping_drop)[0];
				
				foreach($shipping_drop as $key=>$ship_drop){
					
					$delivery_time = date('m/d/Y',strtotime($ship_drop['DeliveryTimestamp'])).'|'.$ship_drop['DeliveryDayOfWeek'];
					$delivery_time1 = $ship_drop['DeliveryTimestamp'].'|'.$ship_drop['DeliveryDayOfWeek'];
					//print_r($delivery_time); dd();
					$dropdown		.=  '<option ship_value="'.key($ship_drop['shipping']).'" value="'.current($ship_drop['shipping']).'" delivery_time="'.$delivery_time.'" delivery_time1="'.$delivery_time1.'">'.str_replace('_',' ',key($ship_drop['shipping'])).' - $'.current($ship_drop['shipping']).'</option>';
				}
				$ship_drop 					= reset($shipping_drop);
				$shipping_type_value 	=  key($ship_drop['shipping']);
				$shipping_cost 			= current($ship_drop['shipping']);
				$delivery_time 			= $ship_drop['DeliveryTimestamp'].'|'.$ship_drop['DeliveryDayOfWeek'];
			}else{
				$dropdown		=  '<option value="">'.$shipping_drop['err'].'</option>';
			}
		}
		if($shipping == 'default_ship'){
			$shipping_drop = $this->fedExRate($to_address,$to_address);
			if(!isset($shipping_drop['err'])){
			//return $shipping_drop;
				$dropdown = '';
				foreach($shipping_drop as $key=>$ship_drop){
					$delivery_time = date('m/d/Y',strtotime($ship_drop['DeliveryTimestamp'])).'|'.$ship_drop['DeliveryDayOfWeek'];
					$delivery_time1 = $ship_drop['DeliveryTimestamp'].'|'.$ship_drop['DeliveryDayOfWeek'];
					//print_r($delivery_time); dd();
					$dropdown		.=  '<option ship_value="'.key($ship_drop['shipping']).'" value="'.current($ship_drop['shipping']).'" delivery_time="'.$delivery_time.'" delivery_time1="'.$delivery_time1.'">'.str_replace('_',' ',key($ship_drop['shipping'])).' - $'.current($ship_drop['shipping']).'</option>';
				}
				$ship_drop 					= reset($shipping_drop);
				$shipping_type_value 	=  key($ship_drop['shipping']);
				$shipping_cost 			= current($ship_drop['shipping']);
				$delivery_time 			= $ship_drop['DeliveryTimestamp'].'|'.$ship_drop['DeliveryDayOfWeek'];
				//print_r($delivery_time); dd();
			}else{
				$dropdown		=  '<option value="">'.$shipping_drop['err'].'</option>';
			}
		}
		
		return ['subtotal'=>number_format($subtotal,2),'total'=>number_format($subtotal+$shipping_cost,2),'shipping_cost'=>number_format($shipping_cost,2),'per_porduct_cost'=>number_format($per_porduct_cost,2),'sfaddress'=>$sfaddress,'from_address_id'=>$from_address_id,'staddress'=>$staddress,'to_address_id'=>$to_address_id,'dropdown'=>$dropdown,'shipping'=>$shipping,'shipping_type_value'=>$shipping_type_value,'delivery_time'=>$delivery_time];
	}
	public function getAddress($address_id){
		return Address::select('*')->join('US_STATES','US_STATES.ID','=','addresses.state')->join('US_CITIES','US_CITIES.ID','=','addresses.city')->where('addresses.id',$address_id)->first();
	}
	public function fedExRate($from_address,$to_address){
		//print_r($to_address); dd();
		$weight = 1;
		$rateRequest = FedEx::rateRequest();
		$shipment = new \Arkitecht\FedEx\Structs\RequestedShipment();
		//$shipment->TotalWeight = new \Arkitecht\FedEx\Structs\Weight(\Arkitecht\FedEx\Enums\WeightUnits::VALUE_LB, $weight);

		$shipment->Shipper = new \Arkitecht\FedEx\Structs\Party();
		$shipment->Shipper->Address = new \Arkitecht\FedEx\Structs\Address(
			$from_address->street_address.' '.$from_address->street_address_2, //address
			$from_address->CITY, // city
			$from_address->STATE_CODE, // state
			$from_address->zip_code, //zipcode
			null, 'US');

		$shipment->Recipient = new \Arkitecht\FedEx\Structs\Party();
		$shipment->Recipient->Address = new \Arkitecht\FedEx\Structs\Address(
			$to_address->street_address.' '.$to_address->street_address_2, //address
			$to_address->CITY, // city
			$to_address->STATE_CODE, // state
			$to_address->zip_code, //zipcode
			null, 'US');

		$lineItem = new \Arkitecht\FedEx\Structs\RequestedPackageLineItem();
		$lineItem->Weight = new \Arkitecht\FedEx\Structs\Weight(\Arkitecht\FedEx\Enums\WeightUnits::VALUE_LB, $weight);
		$lineItem->GroupPackageCount = 1;
		$shipment->PackageCount = 1;

		$shipment->RequestedPackageLineItems = [
			$lineItem
		];

		$rateRequest->Version = FedEx::rateService()->version;
		$rateRequest->ReturnTransitAndCommit = true;
		$rateRequest->setRequestedShipment($shipment);

		$rate = FedEx::rateService();

		$response = $rate->getRates($rateRequest);
		$rates = [];

		
		if ($response->HighestSeverity == 'SUCCESS') {
			foreach ($response->RateReplyDetails as $rate) {
				$rates[] = array(
										'shipping'=>[$rate->ServiceType => $rate->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount],
										'DeliveryDayOfWeek' => $rate->DeliveryDayOfWeek,
										'DeliveryTimestamp' => $rate->DeliveryTimestamp
										);
			}
		}else{
			$rates['err'] = $response->Notifications[0]->Message;
			//print_r($response->Notifications[0]->Message); dd();
		}
		return $rates;
	}
	public function fedExShip(){
		$weight = 5;
		$rateRequest = FedEx::rateRequest();
		$shipment = new \Arkitecht\FedEx\Structs\RequestedShipment();
		//$shipment->TotalWeight = new \Arkitecht\FedEx\Structs\Weight(\Arkitecht\FedEx\Enums\WeightUnits::VALUE_LB, $weight);

		$shipment->Shipper = new \Arkitecht\FedEx\Structs\Party();
		$shipment->Shipper->Address = new \Arkitecht\FedEx\Structs\Address(
			'8580 W PICO BLVD', //address
			'LOS ANGELES', // city
			'CA', // state
			'90035', //zipcode
			null, 'US');

		$shipment->Recipient = new \Arkitecht\FedEx\Structs\Party();
		$shipment->Recipient->Address = new \Arkitecht\FedEx\Structs\Address(
			'8580 W PICO BLVD',
			'LOS ANGELES',
			'CA',
			'90035',
			null, 'US');

		$lineItem = new \Arkitecht\FedEx\Structs\RequestedPackageLineItem();
		$lineItem->Weight = new \Arkitecht\FedEx\Structs\Weight(\Arkitecht\FedEx\Enums\WeightUnits::VALUE_LB, $weight);
		$lineItem->GroupPackageCount = 1;
		$shipment->PackageCount = 1;

		$shipment->RequestedPackageLineItems = [
			$lineItem
		];

		$rateRequest->Version = FedEx::rateService()->version;

		$rateRequest->setRequestedShipment($shipment);

		$rate = FedEx::rateService();

		$response = $rate->getRates($rateRequest);
		//return $response;

		$rates = [];

		
		if ($response->HighestSeverity == 'SUCCESS') {
			foreach ($response->RateReplyDetails as $rate) {
				$rates[$rate->ServiceType] = $rate->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
			}
		}
		return $rates;
	}
}