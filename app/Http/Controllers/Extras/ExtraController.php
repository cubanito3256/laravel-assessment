<?php

namespace App\Http\Controllers\Extras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExtraController extends Controller
{
    public function getInfo(Request $request){
        $params = [
            'open_now' => true,
            'sort_by' => 'rating',
            'location' => \__::get($request, 'location', 'Miami, Florida'),
        ];
        
        $response = Http::withToken(env('YELP_API_KEY', 'no-key-defined'))
            ->get(env('YELP_API_URL', 'http://localhost'), 
            $params
        );

        $body = json_decode($response->getBody()->getContents(), true);
        $result = [];

        if (!\__::get($body, 'error')){
            foreach(\__::get($body, 'businesses', []) as $place){
                if ($place['rating'] < 4) continue;

                $address = implode(', ', $place['location']['display_address']);

                $result[] = [
                    'name' => $place['name'],
                    'rating' => $place['rating'], 
                    'gmapsLink' => sprintf("https://www.google.com/maps/search/?api=1&query=%s", urlencode(sprintf("%s %s", $place['name'], $address))),
                    'address' => $address,
                    'phone' => $place['display_phone'],
                    'categories' => implode(', ', array_map(function($item){
                        return $item['title'];
                    }, $place['categories'])),
                    'services' => implode(', ', array_map(function($item){
                        return ucfirst($item);
                    }, $place['transactions'])),
                ];
            }
        }
        else {
            $result = $body;
        }
        
    	return $result;
    }
}
